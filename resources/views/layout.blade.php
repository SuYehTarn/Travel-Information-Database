<!DOCTYPE html>
<html>
<head>
	
  <title>TIDB - @yield('title')</title>

  @include('header')
  
</head>

<body>
  <header class="text-center"><h1>@yield('header')</h1></header>

  @include('nav')

  @yield('content')

</body>

  @yield('script')

</html>
