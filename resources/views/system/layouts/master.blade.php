<!DOCTYPE html>
<html lang="en">
@include('system.layouts.header')

<body class="main-body app sidebar-mini">

    <div id="global-loader" class="light-loader">
        <img src="fonts/loader.svg" class="loader-img" alt="Loader">
    </div>
    <div class="page">
        @include('system.layouts.sidebar')
        @yield('content')
        <div class="main-footer ht-40">
            <div class="container-fluid pd-t-0-f ht-100p">
                <span>Copyright © 2023 <a href="#">Doge Caramelo Coin</a>. Todos os direitos reservados.</span>
            </div>
        </div>

    </div>
    <a href="#top" id="back-to-top"><i class="la la-chevron-up"></i></a>
    @include('system.layouts.footer')
</body>

</html>