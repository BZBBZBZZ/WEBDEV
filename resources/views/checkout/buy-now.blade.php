@extends('layout.mainlayout')

@section('title', 'Buy Now - Checkout')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4"><i class="fas fa-bolt me-2"></i>Buy Now - Checkout</h2>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Order Item</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded me-3"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <p class="text-muted mb-0 small">Qty: {{ $quantity }}</p>
                            </div>
                            <div class="text-end">
                                <strong class="text-success">
                                    Rp {{ number_format($product->getDiscountedPrice() * $quantity, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form (sama seperti checkout index) -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Weight:</span>
                            <strong>{{ $totalWeight }}g</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <strong id="shipping-cost-display">-</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong class="text-success" id="total-amount">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>
                </div>

                <form action="{{ route('checkout.buy-now-process') }}" method="POST" id="checkout-form">
                    @csrf

                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control" required
                                    value="{{ old('customer_name', Auth::user()->name) }}">
                                @error('customer_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="customer_phone" class="form-control" required
                                    value="{{ old('customer_phone') }}">
                                @error('customer_phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="customer_address" class="form-control" rows="3" required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Province <span class="text-danger">*</span></label>
                                <select name="province_id" id="province" class="form-select" required>
                                    <option value="">Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <select name="city_id" id="city" class="form-select" required disabled>
                                    <option value="">Select City</option>
                                </select>
                                @error('city_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">District <span class="text-danger">*</span></label>
                                <select name="district_id" id="destination_district" class="form-select" required disabled>
                                    <option value="">Select District</option>
                                </select>
                                @error('district_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="courier-options" class="mb-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Please select destination district to see shipping options
                                </div>
                            </div>

                            <input type="hidden" name="courier_code" id="courier_code">
                            <input type="hidden" name="courier_service" id="courier_service">
                            <input type="hidden" name="shipping_cost" id="shipping_cost">

                            <button type="submit" class="btn btn-success w-100" id="submit-btn" disabled>
                                <i class="fas fa-check-circle me-2"></i>Place Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const subtotal = {{ $subtotal }};
        const totalWeight = {{ $totalWeight }};

        document.getElementById('province').addEventListener('change', async function() {
            const provinceId = this.value;
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('destination_district');

            citySelect.innerHTML = '<option value="">Loading...</option>';
            citySelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Select District</option>';
            districtSelect.disabled = true;
            document.getElementById('courier-options').innerHTML =
                '<div class="alert alert-info">Please select district first</div>';
            document.getElementById('submit-btn').disabled = true;

            if (!provinceId) return;

            try {
                const response = await fetch(`/checkout/cities/${provinceId}`);
                const result = await response.json();

                if (result.success && result.data) {
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    result.data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                    citySelect.disabled = false;
                }
            } catch (error) {
                console.error('Error loading cities:', error);
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            }
        });

        document.getElementById('city').addEventListener('change', async function() {
            const cityId = this.value;
            const districtSelect = document.getElementById('destination_district');

            districtSelect.innerHTML = '<option value="">Loading...</option>';
            districtSelect.disabled = true;
            document.getElementById('courier-options').innerHTML =
                '<div class="alert alert-info">Please select district first</div>';
            document.getElementById('submit-btn').disabled = true;

            if (!cityId) return;

            try {
                const response = await fetch(`/checkout/districts/${cityId}`);
                const result = await response.json();

                if (result.success && result.data) {
                    districtSelect.innerHTML = '<option value="">Select District</option>';
                    result.data.forEach(district => {
                        districtSelect.innerHTML +=
                            `<option value="${district.id}">${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                }
            } catch (error) {
                console.error('Error loading districts:', error);
                districtSelect.innerHTML = '<option value="">Error loading districts</option>';
            }
        });

        document.getElementById('destination_district').addEventListener('change', calculateShipping);

        async function calculateShipping() {
            const destinationDistrict = document.getElementById('destination_district').value;

            if (!destinationDistrict) {
                document.getElementById('courier-options').innerHTML =
                    '<div class="alert alert-info">Please select district first</div>';
                return;
            }

            console.log('🚀 Calculating shipping...', {
                destination: destinationDistrict,
                weight: totalWeight
            });

            const courierOptionsDiv = document.getElementById('courier-options');
            courierOptionsDiv.innerHTML =
                '<div class="text-center"><div class="spinner-border text-primary"></div><p class="mt-2">Loading...</p></div>';

            try {
                const url = `${window.location.origin}/checkout/calculate-shipping`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'ngrok-skip-browser-warning': 'true'
                    },
                    body: JSON.stringify({
                        destination_district: destinationDistrict,
                        total_weight: totalWeight
                    })
                });

                console.log('✅ Response status:', response.status);

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ Server error:', errorText);
                    throw new Error(`Server error: ${response.status}`);
                }

                const result = await response.json();
                console.log('✅ Response:', result);

                if (result.success && result.costs && result.costs.length > 0) {
                    displayCourierOptions(result.costs);
                } else {
                    courierOptionsDiv.innerHTML =
                        '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>No courier available</div>';
                }
            } catch (error) {
                console.error('❌ Fetch Error:', error);
                courierOptionsDiv.innerHTML =
                    `<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Network error: ${error.message}</div>`;
            }
        }

        function displayCourierOptions(costs) {
            const courierOptionsDiv = document.getElementById('courier-options');

            let html =
                '<label class="form-label fw-bold">Select Courier <span class="text-danger">*</span></label><div class="list-group">';

            costs.forEach(cost => {
                const etdDisplay = cost.etd ? ` (${cost.etd})` : '';

                html += `
            <label class="list-group-item list-group-item-action cursor-pointer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check w-100">
                        <input class="form-check-input" type="radio" name="courier_service_radio" 
                               value="${cost.code}|${cost.service}|${cost.cost}" 
                               data-code="${cost.code}"
                               data-service="${cost.service}"
                               data-cost="${cost.cost}"
                               onchange="updateShippingCost(${cost.cost}, '${cost.code}', '${cost.service}')"
                               required>
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="ms-2">
                                <strong>${cost.name}</strong> - ${cost.service}<br>
                                <small class="text-muted">${cost.description}${etdDisplay}</small>
                            </div>
                            <div class="text-end">
                                <strong class="text-primary">Rp ${cost.cost.toLocaleString('id-ID')}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </label>
        `;
            });

            html += '</div>';
            courierOptionsDiv.innerHTML = html;
        }

        function updateShippingCost(cost, code, service) {
            document.getElementById('courier_code').value = code;
            document.getElementById('courier_service').value = service;
            document.getElementById('shipping_cost').value = cost;
            document.getElementById('shipping-cost-display').textContent = 'Rp ' + cost.toLocaleString('id-ID');

            const total = subtotal + cost;
            document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('submit-btn').disabled = false;
        }
    </script>
@endpush
