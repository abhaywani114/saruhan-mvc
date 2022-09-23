@extends('saruhanweb.master')
@section('content')
<div class="statistic">
    <div class="statisticHeader">
        <span>Tüm İstatistikler</span>
        <h3>Performance</h3>
    </div>
    <div class="statisticMain">
        <div class="left">
            <table class="statisticTable">
                <tbody>
                    <tr>
                        <td>Bugün Tekil Ziyaretçi</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Bugün Çoğul Ziyaretçi</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Dün Tekil Ziyaretçi</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Dün Çoğul Ziyaretçi</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Toplam Tekil Ziyaretçi</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Toplam Çoğul Ziyaretçi</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="right">
            <div class="online">
                <span class="title">Şu anki Etkin Kullanıcı Sayısı</span>
                <span class="count">0</span>
                <span class="info">Dakina bazında sayfa görüntülenme sayısı</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3">
        <div class="infoBox">
            <img src="{!! get_asset('img/icons/page.png') !!}" width="60px" height="60px" alt="">
            <span class="title">Sayfalar</span>
            <span class="count">Toplam : 0</span>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="infoBox">
            <img src="{!! get_asset('img/icons/gallery.png') !!}" width="60px" height="60px" alt="">
            <span class="title">Galeri</span>
            <span class="count">Toplam : 0</span>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="infoBox">
            <img src="{!! get_asset('img/icons/contact.png') !!}" width="60px" height="60px" alt="">
            <span class="title">İletişim</span>
            <span class="count">Toplam : 0</span>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="infoBox">
            <img src="{!! get_asset('img/icons/contact.png') !!}" width="60px" height="60px" alt="">
            <span class="title">Ayarlar</span>
            <span class="count">Toplam : 0</span>
        </div>
    </div>
</div>
@endsection
