<!doctype html>
<html>
<head>
    <title>Saruhan Web Ajans | Yönetim Paneli</title>
    <link rel="stylesheet" href="{!! get_asset('plugins/sweetAlert/sweetalert.css') !!}">
    <link rel="stylesheet" href="{!! get_asset('plugins/bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! get_asset('plugins/richtexteditor/rte_theme_default.css') !!}" />
    <link rel="stylesheet" href="{!! get_asset('plugins/fancyapps/fancybox.css') !!}" />
    <link rel="stylesheet" href="{!! get_asset('css/saruhanweb.css') !!}">
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="menuTab">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="logo">
                    <a href="{!! link_to('saruhanweb') !!}" title="Saruhan Web Ajans">
                        SaruhanWebAjans
                    </a>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="rightList">
                    <ul>
                        <li><a href="">{!! lang('dashboard','web_site')!!} <img src="{!! get_asset('img/icons/globe.png') !!}" width="18px" height="18px" alt="Profil"></a></li>
                        <li><a href="">{!! lang('dashboard','profile')!!} <img src="{!! get_asset('img/icons/user.png') !!}" width="18px" height="18px" alt="Profil"></a></li>
                        <li><a href="{!! link_to('saruhanweb/logout')!!}" title="{!! lang('dashboard','logout')!!}">{!! lang('dashboard','logout')!!} <img src="{!! get_asset('img/icons/logout.png') !!}" width="18px" height="18px" alt="{!! lang('dashboard','logout')!!}"></a></li>
                        <li>
                            <div class="language">
                                <select name="" id="langSelectAdmin">
                                    @foreach($langs as $lang)
                                    <option value="{!! $lang->seo !!}" @if($lang->seo == get_lang()) selected="selected" @endif>{!! $lang->seo !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2">
                <div class="menu">
                    <h3>Yönetim Paneli</h3>
                    <ul>
                        <li>
                            <a href="" title="">
                                <img src="{!! get_asset('img/icons/page.png') !!}" width="25px" height="25px" alt="">
                                <span>Sayfalar</span>
                            </a>
                            <ul>
                                <li><a href="{!! link_to('saruhanweb/add-page') !!}">Sayfa Ekle</a></li>
                                <li><a href="{!! link_to('saruhanweb/page') !!}">Sayfalar</a></li>
                                <li><a href="{!! link_to('saruhanweb/page-category') !!}">Kategoriler</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="" title="">
                                <img src="{!! get_asset('img/icons/gallery.png') !!}" width="25px" height="25px" alt="">
                                <span>Galeri</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="">Fotoğraf Galeri</a>
                                    <ul>
                                        <li><a href="{!! link_to('saruhanweb/gallery') !!}">Görseller</a></li>
                                        <li><a href="{!! link_to('saruhanweb/gallery-category') !!}">Kategoriler</a></li>
                                    </ul>
                                </li>
                                <li><a href="{!! link_to('saruhanweb/video-gallery') !!}">Video Galeri</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{!! link_to('saruhanweb/contact') !!}" title="">
                                <img src="{!! get_asset('img/icons/contact.png') !!}" width="25px" height="25px" alt="">
                                <span>İletişim</span>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <img src="{!! get_asset('img/icons/settings.png') !!}" width="25px" height="25px" alt="">
                                <span>Ayarlar</span>
                            </a>
                            <ul>
                                <li><a href="{!! link_to('saruhanweb/options') !!}">Site Ayarları</a></li>
                                <li><a href="{!! link_to('saruhanweb/users') !!}">Kullanıcılar</a></li>
                                <li><a href="{!! link_to('saruhanweb/user-statistic') !!}">Kullanıcı Hareketleri</a></li>
                                <li><a href="{!! link_to('saruhanweb/form-settings') !!}">Form Ayarları</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="" title="">
                                <img src="{!! get_asset('img/icons/mechanism.png') !!}" width="25px" height="25px" alt="">
                                <span>Webmaster</span>
                            </a>
                            <ul>
                                <li><a href="{!! link_to('saruhanweb/languages') !!}">Diller</a></li>
                                <li><a href="{!! link_to('saruhanweb/typography') !!}">Typography</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-10">
            @yield('content')
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="copyright">
        © Copyright | Saruhan Web Ajans
    </div>
</footer>
<script src="{!! get_asset('plugins/jquery/jquery.js') !!}"></script>
<script src="{!! get_asset('plugins/sweetAlert/sweetalert.js') !!}"></script>
<script src="{!! get_asset('plugins/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! get_asset('plugins/richtexteditor/rte.js') !!}"></script>
<script src="{!! get_asset('plugins/richtexteditor/plugins/all_plugins.js') !!}"></script>
<script src="{!! get_asset('plugins/fancyapps/fancybox.umd.js') !!}"></script>
<script src="{!! get_asset('js/default.js') !!}"></script>
@yield('js')
</body>
</html>
