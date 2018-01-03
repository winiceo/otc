<nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-md">
    <div class="container">
        <!-- Branding Image -->
        {{ link_to_route('site.home', config('app.name', 'Laravel'), [], ['class' => 'navbar-brand']) }}

        <!-- Collapsed Hamburger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav">
                <li class="nav-item">
                    {{ link_to_route('site.home', __('site.home'), [], ['class' => 'nav-link']) }}
                </li>

                <li class="nav-item">
                    {{ link_to_route('site.trade.buy', __('site.trade.buy'), ['coin'=>1], ['class' => 'nav-link']) }}
                </li>

                <li class="nav-item">
                    {{ link_to_route('site.trade.sell', __('site.trade.sell'), ['coin'=>1], ['class' => 'nav-link']) }}
                </li>

                <li class="nav-item">
                    {{ link_to_route('site.advert.create', __('site.advert.create'), [], ['class' => 'nav-link']) }}
                </li>


            </ul>


            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">{{ link_to_route('login', __('auth.login'), [], ['class' => 'nav-link']) }}</li>
                    <li class="nav-item">{{ link_to_route('register', __('auth.register'), [], ['class' => 'nav-link']) }}</li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            {{ link_to_route('users.show', __('users.public_profile'), Auth::user(), ['class' => 'dropdown-item']) }}
                            {{ link_to_route('users.edit', __('users.settings'), [], ['class' => 'dropdown-item']) }}
                            {{ link_to_route('site.users.orders', __('users.orders'), [], ['class' => 'dropdown-item']) }}
                            {{ link_to_route('site.users.adverts', __('users.adverts'), [], ['class' => 'dropdown-item']) }}

                            <div class="dropdown-divider"></div>

                            <a href="{{ url('/logout') }}"
                                class="dropdown-item"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                @lang('auth.logout')
                            </a>

                            <form id="logout-form" class="d-none" action="{{ url('/logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

