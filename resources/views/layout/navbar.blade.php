<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="fas fa-birthday-cake me-2"></i>Po Bakery
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/employees">Our Team</a></li>
                <li class="nav-item"><a class="nav-link" href="/locations">Locations</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('testimonials.index') }}">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="/about-us">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact-us">Contact</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    {{-- Cart & Orders Links --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            @if(Auth::user()->carts->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                    {{ Auth::user()->carts->sum('quantity') }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.index') }}">
                            <i class="fas fa-receipt"></i> My Orders
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->isAdmin())
                                <span class="badge bg-danger ms-1">Admin</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>Profile
                            </a></li>
                            
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-header text-danger"><strong>ADMIN PANEL</strong></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.users.index') }}">
                                    <i class="fas fa-users-cog me-2"></i>Manage Users
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.products.index') }}">
                                    <i class="fas fa-box me-2"></i>Manage Products
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.categories.index') }}">
                                    <i class="fas fa-list me-2"></i>Manage Categories
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.employees.index') }}">
                                    <i class="fas fa-users me-2"></i>Manage Employees
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.promos.index') }}">
                                    <i class="fas fa-tags me-2"></i>Manage Promos
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.locations.index') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Manage Locations
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.transactions.index') }}">
                                    <i class="fas fa-cash-register me-2"></i>Manage Transactions
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.custom-orders.index') }}">
                                    <i class="fas fa-clipboard-list me-2"></i>Custom Orders
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.testimonials.index') }}">
                                    <i class="fas fa-comments me-2"></i>Manage Testimonials
                                </a></li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white d-inline-block" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>