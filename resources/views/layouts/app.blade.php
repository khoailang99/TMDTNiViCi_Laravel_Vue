<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/40044bf2e6.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/client/home.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app" class="wrapper">
        <div class="css-82517a">
            <div class="css-2a86d2">
                <div class="css-4c8fe3">
                    <div class="css-291b85"></div>
                    <a href="tel:18006867" data-track-content="true" data-content-region-name="taskbar" data-content-name="hotlineSupportURL" class="css-f88ce3">
                        <span size="18" color="#fff" class="css-46e913">
                            <i class="fas fa-headphones-alt"></i>
                        </span>
                        <div class="spacer css-508a4d"></div>Tư vấn mua hàng: 
                        <span class="highlight">1800 6867</span>
                    </a>
                    <a href="tel:18006865" data-track-content="true" data-content-region-name="taskbar" data-content-name="hotlineSupportURL" class="css-f88ce3">
                        <span size="18" color="#fff" class="css-46e913">
                            <i class="fas fa-headphones-alt"></i>
                        </span>
                        <div class="spacer css-508a4d"></div>CSKH: 
                        <span class="highlight">1800 6865</span>
                    </a>
                    <a href="" data-track-content="true" data-content-region-name="taskbar" data-content-nam="techNewsURL" class="css-f88ce3">
                        <span size="18" color="#fff" class="css-07bac8">
                            <i class="far fa-newspaper"></i>
                        </span>
                        <div class="spacer css-508a4d"></div> 
                        <span> Tin công nghệ </span>     
                    </a>
                </div>
            </div>
        </div>
        <div class="header-bottom css-2b3b80">
            <div class="css-fef782">
                <div class="css-0c68ee">
                    <div class="css-cddb72">
                        <a data-track-content="true" data-content-region-name="headerBar" data-content-name="logoPhongVu" data-content-target="" href="/">
                            <img src="https://phongvu.vn/phongvu/logo.svg " alt="phongvu" class="css-1hqxbf2">
                        </a>
                        <div class="css-82a2bb">
                            <div class="css-982563" tabindex="0">
                                <button class="css-ba45e7" @click.stop="prodCatalogBtnClicked= prodCatalogBtnClicked ? false : true">
                                    <span size="20" class="css-e8a5ca">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="100%" height="100%" viewBox="0 0 24 24" stroke-width="2.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <line x1="4" y1="6" x2="20" y2="6" />
                                            <line x1="4" y1="12" x2="20" y2="12" />
                                            <line x1="4" y1="18" x2="20" y2="18" />
                                        </svg>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    <span class="css-1f11d1">Danh mục sản phẩm</span>
                                </button>
                            </div>

                            <div v-bind:class="{active: prodCatalogBtnClicked}" v-click-outside="turnOffProdCDropDown" class="css-a4cf9b" data-popper-reference-hidden="false" data-popper-escaped="false" data-popper-placement="bottom-start" style="position: absolute; left: 0px; top: 0px; right: auto; bottom: auto; transform: translate(72.8px, 44.8px);">
                                <div origin="center top" class="css-3846b3">
                                    <div class="css-bbfd09">
                                        <div id="css-768aa5" @mouseleave ="mouseleaveMI()" > 
                                            <div class="css-74506d">
                                                <div class="css-167cc7">
                                                    @foreach ($prodTypeList as $prodT)
                                                        <div v-on:mouseover='mouseoverMI({!! json_encode($prodT -> childLv) !!})' data-track-content="true" data-content-region-name="megaMenu" data-content-name="Laptop & Macbook" class="css-036586">
                                                            <a class="css-270e69">
                                                                <div class="css-7ef8c6">
                                                                    <span>
                                                                        <div height="22" width="22" class="css-b45459">
                                                                            <picture>
                                                                                <img class="lazyload css-4197f7" alt="" data-src="https://lh3.googleusercontent.com/HlvqHeKrnQcQews3r-pJDg78HfAqQ3bF29HynFvmsiYAEjjaw1S71s5xNhp9ci2gbOw4cHGpgU_rMUtlO3U=w50-rw" src="https://lh3.googleusercontent.com/HlvqHeKrnQcQews3r-pJDg78HfAqQ3bF29HynFvmsiYAEjjaw1S71s5xNhp9ci2gbOw4cHGpgU_rMUtlO3U=w50-rw" loading="lazy" decoding="async">
                                                                            </picture>
                                                                        </div>
                                                                    </span>
                                                                    <div class="css-f73e11"> {{ $prodT -> fatherLv -> Name }}</div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Menu panel -->
                                            <menu-panel-component v-if="isHoveredOver" @changeh-hover-state-menuitem='mouseleaveMI()' v-bind:secondary_tertiary_pt="listSTPT"></menu-panel-component>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="css-e30694">
                    <div data-track-content="true" data-content-region-name="headerBar" data-content-name="searchBox" class="css-da0f8e">
                        <div class="css-382c89">
                            <input type="text" class="search-input css-b75d52" placeholder="Nhập từ khoá cần tìm" role="searchbox" aria-label="Search">
                            <button class="search-icon css-65db16" aria-label="search">
                                <span size="26" color="#FFFFFF" class="css-1c0896">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20px" height="100%" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="10" cy="10" r="7" />
                                        <line x1="21" y1="21" x2="15" y2="15" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="css-7850a7"></div>
                    </div>
                </div>
                <div class="css-4a10cf">
                    <div class="nav-items css-c9b468">
                        <a href="" target="_blank" class="button css-7b8572" data-track-content="true" data-content-region-name="headerBar" data-content-name="promotionLandingIcon">
                            <span size="32" class="css-5158c4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tag" width="100%" height="100%" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M11 3l9 9a1.5 1.5 0 0 1 0 2l-6 6a1.5 1.5 0 0 1 -2 0l-9 -9v-4a4 4 0 0 1 4 -4h4" />
                                    <circle cx="9" cy="9" r="2" />
                                </svg>
                            </span>
                            <div class="spacer css-508a4d"></div>
                            <span class="title"> Khuyến mãi </span>
                        </a>
                        <button data-track-content="true" data-content-region-name="headerBar" data-content-name="orderIcon" class="css-7b8572">
                            <span size="32" class="css-b1e5aa">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check" width="100%" height="100%" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2" />
                                    <rect x="9" y="3" width="6" height="4" rx="2" />
                                    <path d="M9 14l2 2l4 -4" />
                                </svg>
                            </span>
                            <div class="spacer css-508a4d"></div>
                            <span class="title"> Đơn hàng </span>
                        </button>
                        <button data-track-content="true" data-content-region-name="headerBar" data-content-name="loginIcon" class="css-7b8572">
                            <span size="32" class="css-6f221a" style="color: #9E9E9E">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="100%" height="100%" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="7" r="4" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>
                            </span>
                            <div class="spacer css-508a4d"></div>
                            <span class="title">Đăng nhập</span>
                        </button>
                        <div class="css-569256" data-track-content="true" data-content-region-name="headerBar" data-content-name="cartItem" data-content-target="shoppingCart">
                            <div class="css-052cfc" tabindex="0">
                                <a href="/cart" class="button css-7b8572">
                                    <span size="32" class="css-ab162b">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="100%" height="100%" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="9" cy="19" r="2" />
                                            <circle cx="17" cy="19" r="2" />
                                            <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
                                        </svg>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    <span class="title"> Giỏ hàng </span>
                                </a>
                            </div>
                            <div style="position: absolute; left: 0px; top: auto; right: auto; bottom: 0px; transform: translate(863.2px, -78.4px);" class="css-aa3840" data-popper-reference-hidden="false" data-popper-escaped="false" data-popper-placement="top-end">
                                <div origin="center top" class="css-0c6ffe">
                                    <div class="css-1c217b">
                                        <div class="css-c9ba4c">
                                            <div class="css-5cc3ec">
                                                <div class="css-5e1bd0">
                                                    <img class="lazyload css-9280fd" alt="" data-src="https://i.imgur.com/Drj57qu.png" src="https://i.imgur.com/Drj57qu.png" loading="lazy" decoding="async">
                                                </div>
                                                <div class="css-521d92"> Giỏ hàng chưa có sản phẩm nào </div>
                                                <a href="/" class="css-4380d5"> Mua sắm ngay </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="position: absolute; left: 0px; transform: translate(340px, 0px);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="prodCatalogBtnClicked" @click="prodCatalogBtnClicked= false" class="css-0fb746"></div>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <div class="css-700633">
                <div class="css-060572">
                    <div class="footer__map css-2156b4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.1132409246816!2d105.80122644960281!3d21.028154485929985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab424a50fff9%3A0xbe3a7f3670c0a45f!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBHaWFvIHRow7RuZyBW4bqtbiB04bqjaSAoVVRDKQ!5e0!3m2!1svi!2s!4v1604370785879!5m2!1svi!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                    <div class="css-1ff5d7">
                        <div class="css-b1c5a5">
                            <div class="community_NiViCi css-643ddd">
                                <div class="css-556c6a"> Cộng đồng NiViCi </div>
                                <a href="https://phongvu.page.link/fanpage" class="css-2e32a4">
                                    <span size="16" class="css-8ece4e" style="color: #485992;">
                                        <i class="fab fa-facebook-square"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>NiViCi Việt Nam
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-2e32a4">
                                    <span size="16" class="css-8ece4e" style="color: #cf2200;">
                                        <i class="fab fa-youtube"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>NiViCi Media
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-2e32a4">
                                    <span size="16" class="css-8ece4e" style="color: #00AFF7;">
                                        <i class="fas fa-user-friends"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>NiViCi Hội
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-2e32a4">
                                    <span size="16" class="css-8ece4e" style="color: #ff5500;">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    Gọi Mua hàng: 1800 6867 (miễn phí)
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-2e32a4">
                                    <span size="16" class="css-8ece4e" style="color: #ff5500;">
                                        <i class="fas fa-phone-alt"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    Gọi Chăm sóc: 1800 6865 (miễn phí)
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-2e32a4">
                                    <span size="16" class="css-8ece4e" style="color: #ff5500;">
                                        <i class="far fa-comments"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    Chat với tư vấn viên
                                </a>
                            </div>
                            <div class="contact_email css-643ddd">
                                <div class="css-556c6a"> Email liên hệ: </div>
                                <div class="css-057fe2">Hỗ trợ Khách hàng:<a href="mailto:nguyenc431@gmail.com">nguyenc431@gmail.com</a></div>
                                <div class="css-057fe2">Liên hệ báo giá:<a href="mailto:nguyenc431@gmail.com">ntnam@gmail.com</a></div>
                                <div class="css-057fe2">Hợp tác phát triển:<a href="mailto:nguyenc431@gmail.com">vnvn@gmail.com</a></div>
                            </div>
                        </div>
                        <div class="payment_methods css-eb03a4">
                            <div class="css-0bc721">
                                <div class="css-556c6a"> Phương thức thanh toán </div>
                                <a href="https://phongvu.page.link/fanpage" class="css-24329a">
                                    <span size="30" color="#3e3e3e" class="css-554658">
                                        <i class="fas fa-qrcode"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div> 
                                    QR Code
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-24329a">
                                    <span size="30" color="#3e3e3e" class="css-554658">
                                        <i class="far fa-money-bill-alt"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    Tiền mặt
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-24329a">
                                    <span size="30" color="#3e3e3e" class="css-554658">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    Trả góp
                                </a>
                                <a href="https://phongvu.page.link/fanpage" class="css-24329a">
                                    <span size="30" color="#3e3e3e" class="css-554658">
                                        <i class="far fa-credit-card"></i>
                                    </span>
                                    <div class="spacer css-508a4d"></div>
                                    Internet Banking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright css-aa9c4a">
                    <span>
                        Copyright @1999 nivici.com. Bản quyền thông tin trên website thuộc về nivici.com!
                    </span>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
