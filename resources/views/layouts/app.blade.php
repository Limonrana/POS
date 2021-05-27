@include('partials.header')

@guest

@else
    @include('partials.sidebar')
    @include('partials.topbar')
@endguest

@yield('content')

@include('partials.footer')
