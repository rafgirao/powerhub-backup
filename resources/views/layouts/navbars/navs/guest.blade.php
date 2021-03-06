<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-xl navbar-light">
    <div class="container ml-xl-9">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/white.svg" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse navbar-custom-collapse collapse mr-xl--9" id="navbar-collapse">
            <!-- Collapse header -->
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/favicon.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navbar items-->
            <ul class="navbar-nav mr-auto">
                @auth()
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <span class="nav-link-inner--text">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('page.lock') }}" class="nav-link">--}}
{{--                            <span class="nav-link-inner--text">Lock</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <span class="nav-link-inner--text">{{ __('Perfil') }}</span>
                        </a>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <span class="nav-link-inner--text">{{ __('Home') }}</span>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('login') }}" class="nav-link">--}}
{{--                            <span class="nav-link-inner--text">Planos</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <span class="nav-link-inner--text">{{ __('Login') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <span class="nav-link-inner--text">{{ __('Nova Conta') }}</span>
                        </a>
                    </li>
                @endguest
            </ul>
            <hr class="d-lg-none"/>
            <ul class="navbar-nav align-items-right ml-lg-auto">
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nav-link-icon" href="https://www.facebook.com/creativetim" target="_blank" data-toggle="tooltip" title="" data-original-title="Like us on Facebook">--}}
{{--                        <i class="fab fa-facebook-square"></i>--}}
{{--                        <span class="nav-link-inner--text d-lg-none">Facebook</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nav-link-icon" href="https://www.instagram.com/creativetimofficial" target="_blank" data-toggle="tooltip" title="" data-original-title="Follow us on Instagram">--}}
{{--                        <i class="fab fa-instagram"></i>--}}
{{--                        <span class="nav-link-inner--text d-lg-none">Instagram</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nav-link-icon" href="https://twitter.com/creativetim" target="_blank" data-toggle="tooltip" title="" data-original-title="Follow us on Twitter">--}}
{{--                        <i class="fab fa-twitter-square"></i>--}}
{{--                        <span class="nav-link-inner--text d-lg-none">Twitter</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link nav-link-icon" href="https://github.com/creativetimofficial" target="_blank" data-toggle="tooltip" title="" data-original-title="Star us on Github">--}}
{{--                        <i class="fab fa-github"></i>--}}
{{--                        <span class="nav-link-inner--text d-lg-none">Github</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item d-none d-lg-block ml-lg-4">--}}
{{--                    <a href="https://www.creative-tim.com/product/argon-dashboard-pro" target="_blank" class="btn btn-neutral btn-icon">--}}
{{--                        <span class="btn-inner--icon">--}}
{{--                            <i class="fas fa-sign-in"></i>--}}
{{--                        </span>--}}
{{--                        <span class="nav-link-inner--text">Login</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item d-none d-lg-block ml-lg-3 mr-xl--4">--}}
{{--                    <a href="https://www.creative-tim.com/product/argon-dashboard-pro" target="_blank" class="btn btn-success btn-icon">--}}
{{--                        <span class="btn-inner--icon">--}}
{{--                            <i class="fas fa-shopping-cart"></i>--}}
{{--                        </span>--}}
{{--                        <span class="nav-link-inner--text">Assinar</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

            </ul>
        </div>
    </div>
</nav>
