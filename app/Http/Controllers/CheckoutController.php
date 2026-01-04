<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function index()
    {
        $cartItems = Auth::user()->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->getDiscountedPrice() * $item->quantity;
        });

        $totalWeight = $cartItems->sum(function ($item) {
            return ($item->product->weight ?? 0) * $item->quantity;
        });

        $provinces = $this->rajaOngkirService->getProvinces();

        return view('checkout.index', compact('cartItems', 'provinces', 'subtotal', 'totalWeight'));
    }

    public function getCities($provinceId)
    {
        try {
            $cities = $this->rajaOngkirService->getCitiesByProvince($provinceId);

            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            Log::error('Get Cities Error', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load cities'
            ], 500);
        }
    }

    public function getDistricts($cityId)
    {
        try {
            $districts = $this->rajaOngkirService->getDistrictsByCity($cityId);

            return response()->json([
                'success' => true,
                'data' => $districts
            ]);
        } catch (\Exception $e) {
            Log::error('Get Districts Error', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load districts'
            ], 500);
        }
    }

    public function calculateShipping(Request $request)
    {
        try {
            $request->validate([
                'destination_district' => 'required|integer',
                'total_weight' => 'required|integer|min:1'
            ]);

            $originDistrictId = $this->rajaOngkirService->getMagelangDistrictId();
            $destinationDistrictId = $request->destination_district;
            $totalWeight = max((int)$request->total_weight, 1);

            Log::info('=== CALCULATE SHIPPING REQUEST (Controller) ===', [
                'origin' => $originDistrictId,
                'destination' => $destinationDistrictId,
                'weight' => $totalWeight
            ]);

            $costs = $this->rajaOngkirService->calculateShippingCost(
                $originDistrictId,
                $destinationDistrictId,
                $totalWeight
            );

            Log::info('=== CONTROLLER RESPONSE ===', [
                'costs_count' => count($costs),
                'costs' => $costs
            ]);

            return response()->json([
                'success' => true,
                'costs' => $costs,
                'total_costs' => count($costs)
            ]);
        } catch (\Exception $e) {
            Log::error('Calculate Shipping Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping cost: ' . $e->getMessage()
            ], 500);
        }
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'courier_code' => 'required|string',
            'courier_service' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $items = Auth::user()->carts()->with('product')->get();

            if ($items->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty!');
            }

            $subtotal = $items->sum(function ($item) {
                return $item->product->getDiscountedPrice() * $item->quantity;
            });

            $totalAmount = $subtotal + $validated['shipping_cost'];

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'transaction_code' => 'TRX-' . strtoupper(uniqid()),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'province_id' => $validated['province_id'],
                'city_id' => $validated['city_id'],
                'district_id' => $validated['district_id'],
                'courier_code' => $validated['courier_code'],
                'courier_service' => $validated['courier_service'],
                'shipping_cost' => $validated['shipping_cost'],
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            foreach ($items as $item) {
                $transaction->details()->create([
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->getDiscountedPrice(),
                ]);
            }

            Auth::user()->carts()->delete();

            DB::commit();

            return redirect()->route('payment.show', $transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout process error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to process checkout. Please try again.')
                ->withInput();
        }
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);

        session(['buy_now' => [
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ]]);

        $totalWeight = ($product->weight ?? 0) * $request->quantity;
        $subtotal = $product->getDiscountedPrice() * $request->quantity;
        $provinces = $this->rajaOngkirService->getProvinces();

        return view('checkout.buy-now', compact('product', 'totalWeight', 'subtotal', 'provinces'))
            ->with('quantity', $request->quantity);
    }

    public function processBuyNow(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'courier_code' => 'required|string',
            'courier_service' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $buyNowData = session('buy_now');

            if (!$buyNowData) {
                return redirect('/products')
                    ->with('error', 'No product selected for purchase.');
            }

            $product = Product::findOrFail($buyNowData['product_id']);
            $quantity = $buyNowData['quantity'];

            $subtotal = $product->getDiscountedPrice() * $quantity;
            $totalAmount = $subtotal + $validated['shipping_cost'];

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'transaction_code' => 'TRX-' . strtoupper(uniqid()),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'province_id' => $validated['province_id'],
                'city_id' => $validated['city_id'],
                'district_id' => $validated['district_id'],
                'courier_code' => $validated['courier_code'],
                'courier_service' => $validated['courier_service'],
                'shipping_cost' => $validated['shipping_cost'],
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            $transaction->details()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->getDiscountedPrice(),
            ]);

            session()->forget('buy_now');

            DB::commit();

            return redirect()->route('payment.show', $transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Buy now checkout process error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to process buy now checkout. Please try again.')
                ->withInput();
        }
    }
}
