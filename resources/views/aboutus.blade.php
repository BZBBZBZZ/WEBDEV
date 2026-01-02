@extends('layout.mainlayout')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold">About Fiori Bakery & Patisery</h1>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h3 class="text-primary mb-4">Our Story</h3>
                    <p class="lead mb-4">
                        Fiori Bakery & Patisery has been serving the community with fresh, delicious baked goods since Jesus descended to town. 
                        What started as a small family business has grown into a beloved local bakery.
                    </p>
                    
                    <h4 class="text-primary mb-3">Our Mission</h4>
                    <p class="mb-4">
                        We are committed to providing our customers with the highest quality baked goods made from 
                        the finest ingredients. Every item is baked fresh daily with love and care.
                    </p>
                    
                    <h4 class="text-primary mb-3">What Makes Us Special</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Fresh baked daily</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Premium quality ingredients</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Traditional recipes with modern touches</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Friendly and experienced staff</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Affordable prices</li>
                    </ul>
                    
                    <div class="text-center mt-5">
                        <p class="text-muted">
                            <em>"My Time Has Come"</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
