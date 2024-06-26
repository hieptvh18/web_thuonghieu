@php
    $categoryMenus = \App\Models\Category::limit(5)->get();
@endphp
<header class="header">
    <div class="header-top">
        <p class="animate__animated animate__shakeX">Giải pháp thương hiệu tối ưu! Phù hợp nhiều loại hình doanh nghiệp
        </p>
    </div>
    <div class="header-main padding-container">
        <div class="header-main_log">
            {{-- <span>Urban Home</span> --}}
            <a href="/">
                <img src="https://www.adina.vn/assets/images/logo.png" alt="">
            </a>
        </div>
        <form action="{{route('client.service.all')}}" method="GET" class="header-search_form-box">
            <input class="header-search_form-input" name="q" type="search" placeholder="Tìm kiếm dịch vụ">
            <button class="header-search_btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
            <div class="product-result-search">
            </div>
        </form>
        <div class="header-phone header-main_sub">
            <p><i class="fa-solid icon fa-square-phone"></i></p>
            <div class="">
                <span>Hotline:</span>
                <br>
                <p>1900.636.099
                </p>
            </div>
        </div>

        @if (empty(auth()->user()))
            <div class="header-login  header-main_sub">
                <p><i class="fa-solid icon fa-user"></i></p>
                <div class="login-register">
                    <span><a style="" href="{{ route('login.login') }}">Đăng nhập</a>/<a
                            href="{{ route('register.view-register') }}">Đăng ký</a></span>
                    <br>
                    <p>Tài khoản của tôi <i class="fa-solid fa-caret-down"></i>
                    </p>
                </div>
            </div>
        @else
            <div class="header-login dropdown">
                <div onclick="dropdown()" class="header-main_sub dropbtn">
                    <img class="header-info-user-img" src="{{ asset('upload/' . auth()->user()->avatar) }}"
                        alt="">
                    <div class="header-info-user-name" style="margin-left: 15px;">
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div id="myDropdown" class="dropdown-content">
                    @if (auth()->user()->role == 0 || auth()->user()->role == 1)
                        <a href="/quan-tri">Trang quản trị</a>
                    @endif
                    <a href="{{ route('profile.index') }}">Cá nhân</a>
                    {{-- <a href="#">Hoá đơn</a> --}}
                    <a href="{{ route('logOut') }}">Đăng xuất</a>
                </div>
            </div>
        @endif

        <div onclick="openNav()" class="header-cart header-main_sub">
            <div class="header-icon-cart">
                <p><i class="fa-solid icon fa-cart-shopping"></i></p>
                @if (session()->exists('cart'))
                    <span>1</span>
                @else
                    <span>0</span>
                @endif

            </div>
            <div class="">
                <p>Đặt trước
                </p>
            </div>
        </div>
        <div id="mySidenav" class="sidenav cart-list-info">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="" style="padding: 0px 20px ;border-top:1px solid #ccc;">
                @if (session()->exists('cart'))
                    <h4 style="margin-top: 10px;">Tổng số : 1 </h4>
                    <?php $sum = 0; $item = session('cart') ?>
                    <?php $sum += $item['price']; ?>
                    <div class="cart-list-item">
                        <div class="" style="display:flex;justify-content: start">
                            <img class="cart-list-item-img " src="{{ asset('upload/' . $item['img']) }}"
                                alt="">
                            <div class="" style="margin-left:20px">
                                <p class="cart-list-item-name">{{ $item['name'] }}</p>
                                <p class="cart-list-item-price">{{ $item['price'] }}₫</p>
                            </div>
                        </div>
                        <a onclick="return confirm('Bạn có muốn xoá sản phẩm này ?')"
                            href="{{ route('cart.deleteCart', $item['id']) }}" class="btn-cart-delete"><i
                                class="fa-solid fa-trash-can"></i></a>
                    </div>
                    <h4 style="margin-top: 10px;"> Tổng tiền : <?= number_format($sum, 0, '.') ?>₫ </h4>
                @else
                    <span>Giỏ hàng hiện đang trống !!!</span>
                @endif

                <button class="cart-list-view"><a href="{{ route('cart.cart') }}"
                        style="text-decoration:none;color:blue">Xem dịch vụ đã đặt </a></button>
                <button class="cart-list-view"><a href="/order"
                    style="text-decoration:none;color:blue">Tiến hành thanh toán -></a></button>
            </div>
        </div>
    </div>
    <div class="header-menu padding-container">
        <ul class="header-menu_list">
            <li class="header-menu-item"><a href="{{ route('home') }}" class="header-menu-item-link">Trang chủ </a>
            </li>
            {{-- <li class="header-menu-item"><a href="" class="header-menu-item-link">Giới thiệu</a></li> --}}
            {{-- <li class="header-menu-item"><a href="{{route('client.product.product')}}" class="header-menu-item-link">Sản
                    phẩm <i class="fa-solid fa-caret-down"></i></a></li> --}}
            {{-- <li class="header-menu-item"><a href="" class="header-menu-item-link">Tin tức <i
                        class="fa-solid fa-caret-down"></i></a></li> --}}
            <li class="header-menu-item"><a href="/dich-vu/tat-ca/" href=""
                    class="header-menu-item-link">Tất cả dịch vụ</a></li>
            @foreach ($categoryMenus as $menu)
                <li class="header-menu-item"><a href="/dich-vu/{{ $menu->id }}" href=""
                        class="header-menu-item-link">{{ $menu->name }}</a></li>
            @endforeach
            <li class="header-menu-item"><a href="{{ route('contact') }}" href=""
                    class="header-menu-item-link">Liên
                    hệ</a></li>
        </ul>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function() {
        $('.header-search_form-input').on('keyup', function() {
            let keyword = $(this).val();
            $('.product-result-search').css('display', 'block');
            $.get("<?= route('client.product.filterSearch') ?>", {
                keyword: keyword
            }, function($data) {
                $('.product-result-search').html($data);
            });
        });

        $('.header-search_form-input').on('blur', function() {
            setTimeout(() => {
                $('.product-result-search').css('display', 'none');
            }, 1000);
        })
    });
</script>
