@extends('layout.mainlayout')

@section('title', 'Buy Now - Checkout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Buy Now - Order Summary</h5>
                </div>
                <div class="card-body">
                    @if($buyNowItem)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Weight</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{ $buyNowItem['product']->image }}" alt="{{ $buyNowItem['product']->name }}" 
                                                class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                            {{ $buyNowItem['product']->name }}
                                        </td>
                                        <td>Rp {{ number_format($buyNowItem['product']->getDiscountedPrice(), 0, ',', '.') }}</td>
                                        <td>{{ $buyNowItem['quantity'] }}</td>
                                        <td>{{ $buyNowItem['product']->weight }}g</td>
                                        <td>Rp {{ number_format($buyNowItem['product']->getDiscountedPrice() * $buyNowItem['quantity'], 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total Weight:</td>
                                        <td class="fw-bold">{{ $totalWeight }}g</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                                        <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>No product selected!
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Shipping Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.buy-now-process') }}" method="POST" id="checkoutForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                    id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                    id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" 
                                    placeholder="08xxxxxxxxxx" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customer_address" class="form-label fw-semibold">Complete Address</label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                id="customer_address" name="customer_address" rows="3" 
                                placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan/Desa" required>{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="province_id" class="form-label fw-semibold">Province</label>
                                <select class="form-select @error('province_id') is-invalid @enderror" 
                                    id="province_id" name="province_id" required>
                                    <option value="">-- Select Province --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province['id'] }}" {{ old('province_id') == $province['id'] ? 'selected' : '' }}>
                                            {{ $province['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="city_id" class="form-label fw-semibold">City</label>
                                <select class="form-select @error('city_id') is-invalid @enderror" 
                                    id="city_id" name="city_id" required disabled>
                                    <option value="">-- Select Province First --</option>
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="district_id" class="form-label fw-semibold">District</label>
                                <select class="form-select @error('district_id') is-invalid @enderror" 
                                    id="district_id" name="district_id" required disabled>
                                    <option value="">-- Select City First --</option>
                                </select>
                                @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3" id="courierSection" style="display: none;">
                            <label class="form-label fw-semibold">Select Courier</label>
                            <div id="courierOptions" class="row g-2">
                                <!-- Courier options will be loaded here -->
                            </div>
                            <input type="hidden" name="courier_code" id="courier_code">
                            <input type="hidden" name="courier_service" id="courier_service">
                            <input type="hidden" name="shipping_cost" id="shipping_cost">
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100" id="submitBtn" disabled>
                            <i class="fas fa-check-circle me-2"></i>Complete Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Total</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Cost:</span>
                        <span class="fw-bold" id="displayShippingCost">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="h5">Total:</span>
                        <span class="h5 text-success fw-bold" id="displayTotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="mt-3 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Select shipping destination to calculate shipping cost
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const courierSection = document.getElementById('courierSection');
    const courierOptions = document.getElementById('courierOptions');
    const submitBtn = document.getElementById('submitBtn');
    const displayShippingCost = document.getElementById('displayShippingCost');
    const displayTotal = document.getElementById('displayTotal');
    
    const subtotal = {{ $subtotal }};
    const totalWeight = {{ $totalWeight }};

    // Province change
    provinceSelect.addEventListener('change', function() {
        const provinceId = this.value;
        
        citySelect.innerHTML = '<option value="">Loading...</option>';
        citySelect.disabled = true;
        districtSelect.innerHTML = '<option value="">-- Select City First --</option>';
        districtSelect.disabled = true;
        courierSection.style.display = 'none';
        submitBtn.disabled = true;

        if (provinceId) {
            fetch(`/checkout/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">-- Select City --</option>';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                    citySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                    citySelect.innerHTML = '<option value="">Error loading cities</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">-- Select Province First --</option>';
        }
    });

    // City change
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        
        districtSelect.innerHTML = '<option value="">Loading...</option>';
        districtSelect.disabled = true;
        courierSection.style.display = 'none';
        submitBtn.disabled = true;

        if (cityId) {
            fetch(`/checkout/districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">-- Select District --</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching districts:', error);
                    districtSelect.innerHTML = '<option value="">Error loading districts</option>';
                });
        } else {
            districtSelect.innerHTML = '<option value="">-- Select City First --</option>';
        }
    });

    // District change
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        
        courierSection.style.display = 'none';
        submitBtn.disabled = true;

        if (districtId) {
            console.log('=== CALCULATING SHIPPING ===');
            console.log('District ID:', districtId);
            console.log('Weight:', totalWeight);
            
            courierOptions.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Calculating shipping cost...</p></div>';
            courierSection.style.display = 'block';

            fetch('/checkout/calculate-shipping', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    destination: districtId,
                    weight: totalWeight
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('=== RESPONSE DATA ===', data);
                courierOptions.innerHTML = '';
                
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(courier => {
                        courierOptions.innerHTML += `
                            <div class="col-md-6">
                                <div class="card cursor-pointer courier-card" 
                                     data-courier="${courier.code}" 
                                     data-service="${courier.service}" 
                                     data-cost="${courier.cost}">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">${courier.name}</h6>
                                                <small class="text-muted">${courier.service}</small>
                                                <p class="mb-0 mt-1"><small>${courier.description}</small></p>
                                                ${courier.etd ? `<p class="mb-0 text-success"><small><i class="fas fa-clock"></i> ${courier.etd}</small></p>` : ''}
                                            </div>
                                            <div class="text-end">
                                                <strong class="text-success">Rp ${new Intl.NumberFormat('id-ID').format(courier.cost)}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // Add click event to courier cards
                    document.querySelectorAll('.courier-card').forEach(card => {
                        card.addEventListener('click', function() {
                            document.querySelectorAll('.courier-card').forEach(c => {
                                c.classList.remove('border-success', 'bg-light');
                            });
                            
                            this.classList.add('border-success', 'bg-light');
                            
                            document.getElementById('courier_code').value = this.dataset.courier;
                            document.getElementById('courier_service').value = this.dataset.service;
                            document.getElementById('shipping_cost').value = this.dataset.cost;
                            
                            const shippingCost = parseInt(this.dataset.cost);
                            displayShippingCost.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost);
                            displayTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal + shippingCost);
                            
                            submitBtn.disabled = false;
                        });
                    });
                } else {
                    console.warn('No couriers in response');
                    courierOptions.innerHTML = '<div class="col-12"><div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>No courier available for this destination</div></div>';
                }
            })
            .catch(error => {
                console.error('=== FETCH ERROR ===', error);
                courierOptions.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Error:</strong> ${error.message}<br>
                            <small>Check browser console for details (F12)</small>
                        </div>
                    </div>
                `;
            });
        }
    });
});
</script>
@endpush

<style>
.courier-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.courier-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.courier-card.border-success {
    border-color: #198754 !important;
}
</style>
@endsection
