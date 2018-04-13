@section('menu')
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">Logo</a>
                <form action="" method="GET">
                    <div class="form-group search-form">
                        <input type="text" class="form-control" id="search" name="s" placeholder="Поиск" value="{{ Request::get('s') }}">
                        <div class="tips" id="tips">
                        </div>
                    </div>
                </form>
                <script src="{{ asset('js/autocomplit.js') }}"></script>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                    <li class="{{ in_array(\Route::currentRouteName(), ['home', 'admin']) ? 'active' : '' }}"><a
                                href="{{ session('admin', false) ? route('admin') : route('home') }}">Главная</a></li>
                    @if (session('admin') == '1')
                        <li class="{{ \Route::currentRouteName() === 'addEvent' ? 'active' : '' }}"><a
                                    href="{{ route('addEvent') }}">Добавить мероприятие</a></li>
                        <li><a href="{{ url('admin/logout') }}">Выйти (admin)</a></li>
                    @elseif (!Auth::check())
                        <li class="{{ \Route::currentRouteName() === 'register' ? 'active' : '' }}"><a
                                    href="{{ route('register') }}">Регистрация</a></li>
                        <li class="{{ \Route::currentRouteName() === 'login' ? 'active' : '' }}"><a
                                    href="{{ route('login') }}">Авторизация</a></li>
                    @else
                        <li class="{{ \Route::currentRouteName() === 'myEvents' ? 'active' : '' }}"><a
                                    href="{{ route('myEvents') }}">Мои мероприятия</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти
                                ({{ Auth::user()->login }})</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
@endsection