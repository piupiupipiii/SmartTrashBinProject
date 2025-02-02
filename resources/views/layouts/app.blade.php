<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title', 'Segre Bin')</title>

  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  @stack('styles')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="navbar-container">
    <nav class="navbar">
      <h1>Segre Bin</h1>
            <ul>
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="/home">Home</a>
                </li>
                <li class="{{ Request::is('statistic*') ? 'active' : '' }}">
                    <a href="/statistic">Statistic</a>
                </li>
            </ul>
    </nav>
  </div>
  <div class="content-container">
        <main>
            @yield('content')
        </main>
  </div>

  @stack('scripts')
</body>
</html>
