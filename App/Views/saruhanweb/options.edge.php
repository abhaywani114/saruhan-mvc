@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">Site Ayarları</h1>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <form action="" id="OptionsForm">
                <div class="pageMain">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach($langs as $key => $lang)
                            @if($key == 0)
                            @php
                            $active = "active";
                            $show = "show";
                            $ariaSelect = "true";
                            @endphp
                            @else
                            @php
                            $active = "";
                            $show = "";
                            $ariaSelect = "false";
                            @endphp
                            @endif
                            <button class="nav-link {{$active}}" id="nav-{{$lang->seo}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$lang->seo}}" type="button" role="tab" aria-controls="nav-{{$lang->seo}}" aria-selected="{{$ariaSelect}}">{{$lang->title}}</button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach($langs as $key => $lang)
                        @if($key == 0)
                        @php
                        $active = "active";
                        $show = "show";
                        @endphp
                        @else
                        @php
                        $active = "";
                        $show = "";
                        @endphp
                        @endif
                        <div class="tab-pane fade {{$show}} {{$active}}" id="nav-{{$lang->seo}}" role="tabpanel" aria-labelledby="nav-{{$lang->seo}}-tab">
                            <div class="form-group option-group">
                                <label for="">Title (Site Başlığı) <i>i</i></label>
                                <textarea name="title[{{ $lang->seo }}]" id="title_{{$lang->seo}}" rows="2" class="form-control">{{ $content[$lang->seo]['title'] }}</textarea>
                                <div class="result" id="result_title_{{ $lang->seo }}">
                                    <span class="char">{{lang('dashboard','char')}} : <b>0</b></span>
                                    <span class="maxChar">{{lang('dashboard','max')}} : <b>80</b></span>
                                </div>
                            </div>
                            <div class="form-group option-group">
                                <label for="">Description (Site Açıklaması) <i>i</i></label>
                                <textarea name="description[{{ $lang->seo }}]" id="description_{{$lang->seo}}" rows="4" class="form-control">{{ $content[$lang->seo]['description'] }}</textarea>
                                <div class="result" id="result_description_{{ $lang->seo }}">
                                    <span class="char">{{lang('dashboard','char')}} : <b>0</b></span>
                                    <span class="maxChar">{{lang('dashboard','max')}} : <b>180</b></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pageFooter">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="Kaydet"> Kaydet</button>
                </div>
            </form>
        </div>
        <div class="col-xl-4">
            <div class="pageMain">
                <h3 class="subTitle">Logo</h3>
                <form action="" id="addLogoForm" enctype="multipart/form-data">
                    <div class="form-group form-file-group form-file-group-button">
                        <label for="logo">Logo <i>i</i></label>
                        <input type="file" class="form-control" id="logo" name="logo">
                        <button type="submit" class="btn">Logo Ekle</button>
                    </div>
                </form>
                @if(!empty($logo))
                <div class="logo-box">
                    <ul>
                        <li><button type="button" onclick="deleteLogo();"><img src="{{ get_asset('img/icons/trash.png') }}" width="20px" height="20px" alt=""></button></li>
                    </ul>
                    <div class="img">
                        <img src="{!! get_asset('upload/'.$logo) !!}" alt="">
                    </div>
                </div>
                @endif
                <h3 class="subTitle">Favicon</h3>
                <form action="" id="addFaviconForm" enctype="multipart/form-data">
                    <div class="form-group form-file-group form-file-group-button">
                        <label for="">Favicon <i>i</i></label>
                        <input type="file" class="form-control" id="favicon" name="favicon">
                        <button type="submit" class="btn">Favicon Ekle</button>
                    </div>
                </form>
                @if(!empty($favicon))
                <div class="logo-box">
                    <ul>
                        <li><button type="button" onclick="deleteFavicon();"><img src="{{ get_asset('img/icons/trash.png') }}" width="20px" height="20px" alt=""></button></li>
                    </ul>
                    <div class="img">
                        <img src="{!! get_asset('upload/'.$favicon) !!}" alt="">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="pageMain">
        <div class="box">
            <div class="form-group">
                <label for="">Title (Başlık)</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Decription (Açıklama)</label>
                <textarea name="" id="" rows="2" class="form-control"></textarea>
            </div>
            <div class="form-group form-file-group">
                <label for="">Image (Görsel)</label>
                <input type="file" class="form-control">
                <p class="help-text">Önerilen boyut 500px X 500px</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $("#OptionsForm").on("submit",function(event){
            event.preventDefault();
            // title
            var titleCount = $('textarea[name^=title]').length;
            var titleNum = 0;
            $('textarea[name^=title]').each( (index, element) => {
                var id = $('textarea[name^=title]:eq('+index+')').attr('id');
                var idEx = id.split("_");
                var locale = idEx[1];
                var val = $('textarea[name^=title]:eq('+index+')').val();
                if (val == "")
                {
                    $(".pageMain .nav .nav-link").removeClass('active');
                    $(".pageMain .nav .nav-link").attr('aria-selected', 'false');
                    $(".pageMain .nav #nav-" + locale + "-tab").addClass('active');
                    $(".pageMain .nav #nav-" + locale + "-tab").attr('aria-selected', 'true');
                    $(".pageMain .tab-content .tab-pane").removeClass('active show');
                    $(".pageMain .tab-content #nav-"+locale).addClass('active show');
                    $('textarea[name^=title]:eq(' + index + ')').focus();
                    return false;
                }
                titleNum++;
            });
            if (titleNum != titleCount)
            {
                return false;
            }
            // description
            var descCount = $('textarea[name^=description]').length;
            var descNum = 0;
            $('textarea[name^=description]').each( (index, element) => {
                var id = $('textarea[name^=description]:eq('+index+')').attr('id');
                var idEx = id.split("_");
                var locale = idEx[1];
                var val = $('textarea[name^=description]:eq('+index+')').val();
                if (val == "")
                {
                    $(".pageMain .nav .nav-link").removeClass('active');
                    $(".pageMain .nav .nav-link").attr('aria-selected', 'false');
                    $(".pageMain .nav #nav-" + locale + "-tab").addClass('active');
                    $(".pageMain .nav #nav-" + locale + "-tab").attr('aria-selected', 'true');
                    $(".pageMain .tab-content .tab-pane").removeClass('active show');
                    $(".pageMain .tab-content #nav-"+locale).addClass('active show');
                    $('textarea[name^=description]:eq(' + index + ')').focus();
                    return false;
                }
                descNum++;
            });
            if (descNum != descCount)
            {
                return false;
            }
            var formData = $("#OptionsForm").serialize();
            $.ajax({
                url: "update-option",
                type: "post",
                cache: false,
                data: formData,
                beforeSend: function() {
                    $(".pageFooter button").attr('disabled','disapled');
                    Swal.fire({
                        title: '<img src="{{ get_asset("img/icons/loader.gif") }}" width="40px" height="auto">',
                        showConfirmButton: false,
                    })
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    var statu = result.statu;
                    var content = result.content;
                    Swal.fire({
                        icon: statu,
                        title: content,
                        showConfirmButton: false,
                        timerProgressBar:true,
                        timer:2000
                    })
                    $(".pageFooter button").removeAttr('disabled','disapled');
                    if(statu == 'success')
                    {
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    }
                },
                complete: function(){
                }
            });
        })
        $('textarea[name^=title]').each( (index, element) => {
            $('textarea[name^=title]:eq('+index+')').keyup(function(){
                var CharLength = $('textarea[name^=title]:eq('+index+')').val().length;
                var id = $('textarea[name^=title]:eq('+index+')').attr('id');
                var idEx = id.split("_");
                var locale = idEx[1];
                $("#result_title_"+locale+" .char b").text(CharLength);
            });
        })
        $('textarea[name^=description]').each( (index, element) => {
            $('textarea[name^=description]:eq('+index+')').keyup(function(){
                var CharLength = $('textarea[name^=description]:eq('+index+')').val().length;
                var id = $('textarea[name^=description]:eq('+index+')').attr('id');
                var idEx = id.split("_");
                var locale = idEx[1];
                $("#result_description_"+locale+" .char b").text(CharLength);
            });
        })

        $("#addLogoForm").on("submit",function (event){
            event.preventDefault();

            var logo = $('#logo').val();
            if (logo == ""){
                $('#logo').focus();
                return false;
            }

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "add-logo",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                beforeSend: function() {
                    $("#addLogoForm button").attr('disabled','disapled');
                    Swal.fire({
                        title: '<img src="{{ get_asset("img/icons/loader.gif") }}" width="40px" height="auto">',
                        showConfirmButton: false,
                    })
                },
                success: function(response) {
                    // console.log(response)
                    var result = JSON.parse(response);
                    var statu = result.statu;
                    var content = result.content;
                    Swal.fire({
                        icon: statu,
                        title: content,
                        showConfirmButton: false,
                        timerProgressBar:true,
                        timer:2000
                    })
                    $("#addLogoForm button").removeAttr('disabled','disapled');
                    if(statu == 'success')
                    {
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    }
                },
                complete: function(){
                }
            });
        })
        $("#addFaviconForm").on("submit",function (event){
            event.preventDefault();

            var favicon = $('#favicon').val();
            if (favicon == ""){
                $('#favicon').focus();
                return false;
            }

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "add-favicon",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                beforeSend: function() {
                    // $("#addFaviconForm button").attr('disabled','disapled');
                    // Swal.fire({
                    //     title: '<img src="{{ get_asset("img/icons/loader.gif") }}" width="40px" height="auto">',
                    //     showConfirmButton: false,
                    // })
                },
                success: function(response) {
                    console.log(response)
                    // var result = JSON.parse(response);
                    // var statu = result.statu;
                    // var content = result.content;
                    // Swal.fire({
                    //     icon: statu,
                    //     title: content,
                    //     showConfirmButton: false,
                    //     timerProgressBar:true,
                    //     timer:2000
                    // })
                    // $("#addFaviconForm button").removeAttr('disabled','disapled');
                    // if(statu == 'success')
                    // {
                    //     setTimeout(function(){
                    //         window.location.reload();
                    //     }, 2000);
                    // }
                },
                complete: function(){
                }
            });
        })
    })
    function deleteFavicon()
    {
        var yesBtn = "{{lang('dashboard','yes_btn')}}";
        var noBtn = "{{lang('dashboard','no_btn')}}";
        var msg = "{{lang('dashboard','delete_query')}}";
        Swal.fire({
            icon: 'question',
            title: msg,
            showCancelButton:true,
            cancelButtonText: noBtn,
            confirmButtonText: yesBtn,
            preConfirm: () => {
                $.ajax({
                    url: "delete-favicon",
                    type: "post",
                    data: {
                        action : 'deleteFavicon',
                    },
                    success: function(response) {
                        var parse = JSON.parse(response);
                        var statu = parse.statu;
                        var content = parse.content;
                        Swal.fire({
                            position: 'center',
                            icon: statu,
                            title: content,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setTimeout(function(){
                            window.location.reload();
                        }, 2000);
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((response) => {
            return false;
        })
        return false;
    }
</script>
@endsection