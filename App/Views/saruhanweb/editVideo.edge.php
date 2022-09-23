@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','edit_video') }}</h1>
    </div>
    <div class="row">
        <div class="col-xl-9">
            <form action="" id="editVideoForm">
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
                            <div class="form-group">
                                <label for="">Başlık</label>
                                <input type="text" class="form-control" name="title[{{$lang->seo}}]" id="title_{{$lang->seo}}" value="{{ $title[$lang->seo]['title'] }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="">Sıra <i>i</i></label>
                        <input type="text" class="form-control" placeholder="Sıra" name="order_id" value="{{ $order_id }}">
                    </div>
                    <div class="form-group">
                        <label for="">Durum</label>
                        <select name="statu" id="" class="form-control">
                            <option value="1" @if($statu == 1) selected="selected" @endif >Açık</option>
                            <option value="0" @if($statu == 0) selected="selected" @endif>Kapalı</option>
                        </select>
                    </div>
                </div>
                <div class="pageFooter">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
                </div>
            </form>
        </div>
        <div class="col-xl-3">
            <div class="video-box">
                <a href="https://www.youtube.com/watch?v={{ $embed }}" data-fancybox data-type="iframe" data-preload="false">
                    <img src="//img.youtube.com/vi/{{ $embed }}/mqdefault.jpg" width="" height="" alt="" class="img">
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#editVideoForm').on("submit",function (event){
        event.preventDefault();
        // title
        // var titleCount = $('input[name^=title]').length;
        // var titleNum = 0;
        // $('input[name^=title]').each( (index, element) => {
        //     var id = $('input[name^=title]:eq('+index+')').attr('id');
        //     var idEx = id.split("_");
        //     var locale = idEx[1];
        //     var val = $('input[name^=title]:eq('+index+')').val();
        //     if (val == "")
        //     {
        //         $(".pageMain .nav .nav-link").removeClass('active');
        //         $(".pageMain .nav .nav-link").attr('aria-selected', 'false');
        //         $(".pageMain .nav #nav-" + locale + "-tab").addClass('active');
        //         $(".pageMain .nav #nav-" + locale + "-tab").attr('aria-selected', 'true');
        //         $(".pageMain .tab-content .tab-pane").removeClass('active show');
        //         $(".pageMain .tab-content #nav-"+locale).addClass('active show');
        //         $('input[name^=title]:eq(' + index + ')').focus();
        //         return false;
        //     }
        //     else
        //     {
        //         //console.log(index, id, val, locale);
        //     }
        //     titleNum++;
        // });
        // if (titleNum != titleCount)
        // {
        //     return false;
        // }
        // url
        var url = $('input[name^=url]').val();
        if (url == "")
        {
            $('input[name^=url]').focus();
            return false;
        }
        var statu = $('select[name^=statu]').val();
        if (statu == "")
        {
            $('select[name^=statu]').focus();
            return false;
        }
        var formData = $("#editVideoForm").serialize();
        $.ajax({
            url: "{{ $id }}",
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
        return false;
    })

</script>
@endsection