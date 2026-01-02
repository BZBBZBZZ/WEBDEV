@extends('layout.mainlayout')

@section('title', 'Contact Us')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold">Contact Us</h1>
                    <p class="text-muted">Get in touch with Fiori Bakery & Patisery</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="text-primary mb-4">
                                    <i class="fas fa-store me-2"></i>Store Information
                                </h4>

                                <div class="mb-3">
                                    <h6><i class="fas fa-map-marker-alt text-danger me-2"></i>Address</h6>
                                    <p class="text-muted mb-0">123 Jalan Bakery
                                </div>

                                <div class="mb-3">
                                    <h6><i class="fas fa-phone text-success me-2"></i>Phone</h6>
                                    <p class="text-muted mb-0">+62 123 456 789</p>
                                </div>

                                <div class="mb-3">
                                    <h6><i class="fas fa-envelope text-primary me-2"></i>Email</h6>
                                    <p class="text-muted mb-0">fioribakerypatisery@gmail.com</p>
                                </div>

                                <div class="mb-3">
                                    <h6><i class="fas fa-globe text-info me-2"></i>Website</h6>
                                    <p class="text-muted mb-0">af2.test</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="text-primary mb-4">
                                    <i class="fas fa-clock me-2"></i>Business Hours
                                </h4>

                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-2"><strong>Monday</strong></p>
                                        <p class="mb-2"><strong>Tuesday</strong></p>
                                        <p class="mb-2"><strong>Wednesday</strong></p>
                                        <p class="mb-2"><strong>Thursday</strong></p>
                                        <p class="mb-2"><strong>Friday</strong></p>
                                        <p class="mb-2"><strong>Saturday</strong></p>
                                        <p class="mb-2"><strong>Sunday</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-2 text-muted">7:00 AM - 8:00 PM</p>
                                        <p class="mb-2 text-muted">7:00 AM - 8:00 PM</p>
                                        <p class="mb-2 text-muted">7:00 AM - 8:00 PM</p>
                                        <p class="mb-2 text-muted">7:00 AM - 8:00 PM</p>
                                        <p class="mb-2 text-muted">7:00 AM - 9:00 PM</p>
                                        <p class="mb-2 text-muted">6:00 AM - 9:00 PM</p>
                                        <p class="mb-2 text-muted">8:00 AM - 6:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
