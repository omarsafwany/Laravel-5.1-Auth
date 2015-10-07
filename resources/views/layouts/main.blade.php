<html>
    <head>
        <meta charset="utf-8">

        <!-- If you delete this meta tag World War Z will become a reality -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Laravel Auth</title>

        <link rel="stylesheet" href="css/foundation.css">
        <link rel="stylesheet" href="css/normalize.css">
    </head>
    <body>
        <nav class="top-bar" data-topbar role="navigation">
          <ul class="title-area">
            <li class="name">
              <h1><a href="{{route('index')}}">My Site</a></h1>
            </li>
             <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
          </ul>
          <section class="top-bar-section">
            <!-- Right Nav Section -->
            <ul class="right">    
             @if(\Auth::user())
                <li><a href="{{route('change-password')}}">Change Password</a></li>
                <li><a href="{{route('logout')}}">Logout</a></li>
             @else
                <li><a href="{{route('login')}}">Login</a></li>
                <li><a href="{{route('register')}}">Register</a></li>
                <li><a href="{{route('forget-password')}}">Forget Password?!</a></li>
             @endif    
            </ul>
          </section>
        </nav>
    </body>
    
    @if(\Session::has('global'))
        <div class="alert-box success">
            <h4>{{ \Session::get('global') }}</h4>
            <a href="#" class="close">&times;</a>
        </div>
    @endif
    @if(\Session::has('warning'))
        <div class="alert-box warning">
            <h4>{{ \Session::get('warning') }}</h4>
            <a href="#" class="close">&times;</a>
        </div>
    @endif

    @if(\Session::has('reqlog'))
        <div class="alert-box reqlog">
            <h4>{{ \Session::get('reqlog') }}</h4>
            <a href="#" class="close">&times;</a>
        </div>
    @endif

    @if(\Session::has('activate'))
        <div class="alert-box activate">
            <h4>{{ \Session::get('activate') }}</h4>
            <a href="#" class="close">&times;</a>
        </div>
    @endif
    @yield('content')
</html>