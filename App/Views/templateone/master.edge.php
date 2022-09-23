<!doctype html>
<html lang="tr">
    <head>
        <base href="" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no"/>
        <meta name="robots" content="__">
        <!-- Bu Web Sitesi Saruhan Web Ajans tarafından yapılmıştır. 0222 220 03 77 -->
        <title>Saruhan Web Ajans Yönetim Paneli V.5.0</title>
        <meta name="description" content="__" />
        <link rel="Shortcut Icon" href="../../../index.php" type="image/x-icon" />
        <link rel="canonical" href="../../../index.php"/>
        <meta name="publisher" content="__" />
        <meta name="author" content="__">
        <meta property="og:locale" content="tr_TR" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="__" />
        <meta property="og:title" content="__" />
        <meta property="og:description" content="__" />
        <meta property="og:image" content="__" />
        <meta name="twitter:card" content="__" />
        <meta name="twitter:title" content="__" />
        <meta name="twitter:description" content="__" />
        <meta name="twitter:url" content="__" />
        <meta name="twitter:image" content="__" />
        <link rel="stylesheet" href="{!! get_asset('css/style.css') !!}">
    </head>
    <body>
        <header>
            <div class="langList">
                <ul>
                    <li><a href="" title="Türkçe">TR</a></li>
                    <li><a href="" title="İngilizce">EN</a></li>
                </ul>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="/" title="">{!!lang('home','homeTitle')!!}</a></li>
                    <li><a href="../../../index.php" title="">{!!lang('home','pageTitle')!!}</a></li>
                    <li><a href="../../../index.php" title="">{!!lang('home','galleryTitle')!!}</a></li>
                    <li><a href="../../../index.php" title="">{!!lang('home','contactTitle')!!}</a></li>
                </ul>
            </div>
        </header>
        @yield('content')
    </body>
</html>