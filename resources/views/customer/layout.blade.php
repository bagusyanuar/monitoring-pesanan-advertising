<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
          rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.member.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <title>HARI PONSEL</title>
    @yield('css')
</head>
<body>
<div class="nav-wrapper">
    <a class="custom-nav-brand d-flex align-items-center" href="{{ route('customer.home') }}">
        <img src="{{ asset('/assets/images/logo.png') }}" alt="brand-image">
        <p style="font-size: 0.8em; font-weight: 600; margin-bottom: 0">JeeDee</p>
    </a>
    <div class="nav-link-container">
        <a href="{{ route('customer.home') }}"
           class="nav-link-item {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('customer.product') }}" class="nav-link-item {{ request()->is('product*') ? 'active' : '' }}">
            Product
        </a>
        <a href="#" class="nav-link-item">Tentang Kami</a>
        <a href="#" class="nav-link-item">Kontak</a>
    </div>
    <div class="nav-menu-container">
        @auth()
            <a href="#" class="nav-menu-item">
                <i class='bx bx-cart-alt'></i>
                <div class="custom-badge"><span>4</span></div>
            </a>
            <a href="#" class="nav-menu-item">
                <i class='bx bx-user'></i>
            </a>
        @else
            <a href="#" class="nav-menu-item">
                <i class='bx bx-user'></i>
            </a>
        @endauth
    </div>
</div>

<div class="content-wrapper" style="min-height: 350px;">
    @yield('content')
</div>
<div class="custom-footer row" style="margin-right: 0; width: 100%; --bs-gutter-x: 0;">
    <div class="col-3 d-flex justify-content-center align-items-center flex-column">
        <div style="padding: 5px 20px; margin-bottom: 10px; border-radius: 8px; background-color: white"
             class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('/assets/images/logo.png') }}" width="120" style="border-radius: 8px;" alt="brand-image">
        </div>
        <p style="color: white; font-size: 0.8em; font-weight: 600;">Media Percetakan Terpercaya</p>
    </div>
    <div class="col-3 d-flex flex-column">
        <p style="color: white; font-size: 1em; font-weight: 500; letter-spacing: 2px">HARI PONSEL</p>
        <a href="{{ route('customer.home') }}" class="footer-link mb-1">BERANDA</a>

        <a href="#" class="footer-link mb-1">TENTANG KAMI</a>
        <a href="#" class="footer-link">KONTAK</a>
    </div>
    <div class="col-3">
        <p style="color: white; font-size: 1em; font-weight: 500; letter-spacing: 2px">HUBUNGI KAMI</p>
        <a href="#" class="footer-link d-flex align-items-center mb-1">
            <i class='bx bxl-whatsapp me-1'></i>
            <span>(+62) 8963266623</span>
        </a>
        <a href="#" class="footer-link d-flex align-items-center mb-1">
            <i class='bx bxl-instagram me-1'></i>
            <span>@jeedee.advertising</span>
        </a>
        <a href="#" class="footer-link d-flex align-items-center mb-1">
            <i class='bx bx-map me-1'></i>
            <span>jl. kartika no. 16, jebres, surakarta</span>
        </a>
    </div>
    <div class="col-3"></div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@yield('js')
</body>
</html>
