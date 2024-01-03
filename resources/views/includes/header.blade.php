@if(Session::has('success'))
        <h1 style="color:#0FFF50">{{ Session::get('success') }}</h1>
    @endif

    @if(Session::has('fail'))
        <h1 style="color:#a51700">{{ Session::get('fail') }}</h1>
    @endif

    <header class="header">
        <img src="{{ url('app_meta/wlogo.png') }}" alt="" width=100 height=50>
        <lable class="user_navigation">John Doe <a href="{{ url('logout') }}">Logout
                </a< /lable>
    </header>