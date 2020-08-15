<!DOCTYPE html>
<html>
<head>
	
  <title>TIDB - @yield('title')</title>

  @include('header')
  
</head>

<body>

  <div class="jumbotron jumbotron-fluid text-center mb-0">

    <h1>@yield('header')</h1>

  </div>

  @include('nav')

  @yield('content')

</body>

  @yield('script')

</html>
