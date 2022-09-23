@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">İletişim</h1>
    </div>
    <div class="pageMain">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-tr-tab" data-bs-toggle="tab" data-bs-target="#nav-tr" type="button" role="tab" aria-controls="nav-tr" aria-selected="true">Türkçe</button>
                <button class="nav-link" id="nav-en-tab" data-bs-toggle="tab" data-bs-target="#nav-en" type="button" role="tab" aria-controls="nav-en" aria-selected="false">İngilizce</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-tr" role="tabpanel" aria-labelledby="nav-tr-tab">
                <h3 class="subTitle">İletişim Bilgileri</h3>
                <div class="form-group">
                    <label for="">Başlık</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Adres</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control"></textarea>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <h3 class="subTitle">Telefon</h3>
                        <div class="form-group">
                            <label for="">Telefon</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Telefon</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Telefon</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <h3 class="subTitle">E-Mail</h3>
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <h3 class="subTitle">Fax</h3>
                        <div class="form-group">
                            <label for="">Fax</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Fax</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Fax</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <h3 class="subTitle">Sosyal Medya</h3>
                <div class="form-group">
                    <label for="">Facebook</label>
                    <input type="text" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label for="">Instagram</label>
                    <input type="text" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label for="">Twitter</label>
                    <input type="text" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label for="">Youtube</label>
                    <input type="text" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label for="">Linkedin</label>
                    <input type="text" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label for="">Telegram</label>
                    <input type="text" class="form-control" placeholder="Kullanıcı Adı">
                </div>
                <div class="form-group">
                    <label for="">WhatsApp</label>
                    <input type="text" class="form-control" placeholder="0___-___-____">
                </div>
                <div class="form-group">
                    <label for="">WhatsApp Mesajı</label>
                    <textarea name="" id="" rows="3" class="form-control"></textarea>
                </div>
                <h3 class="subTitle">Harita</h3>
                <div class="form-group">
                    <label for="">Başlık</label>
                    <input type="text" class="form-control">
                    <p class="help-text">Örnek: Adres Bilgileri</p>
                </div>
                <div class="form-group">
                    <label for="">Harita İframe Kodu <i>i</i></label>
                    <textarea name="" id="" rows="5" class="form-control"></textarea>
                    <p class="help-text">Harita Kodu Oluştur. <a href="//www.google.com.tr/maps/" target="_blank">Google Maps</a></p>
                </div>
                <div class="form-group">
                    <label for="">Harita Url <i>i</i></label>
                    <input type="text" class="form-control" placeholder="https://...">
                    <p class="help-text">Harita bağlantı gönderme bağlantısı. https://goo.gl/maps/...</p>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-en" role="tabpanel" aria-labelledby="nav-en-tab">...</div>
        </div>
    </div>
    <div class="pageFooter">
        <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="Kaydet"> Kaydet</button>
    </div>
</div>
@endsection