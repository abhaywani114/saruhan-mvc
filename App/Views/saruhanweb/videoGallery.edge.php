@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','videos') }}</h1>
    </div>
    <div class="row">
        <div class="col-xl-7">
            @foreach($videos as $video)
            <div class="video-list-box">
                <img src="//img.youtube.com/vi/{{ $video->embed }}/mqdefault.jpg" width="120px" height="90px" alt="" class="img">
                <h2>{{ $video->title }}</h2>
                <ul class="info">
                    <li>{{ lang('dashboard','video_views') }} : <b> @if($video->views == null) 0 @else {{ $video->views }} @endif</b></li>
                    <li>{{ lang('dashboard','video_order') }} : <b> {{ $video->order_id }}</b></li>
                    <li>{{ lang('dashboard','video_statu') }} :
                        @if( $video->statu == 1)
                        <span class="badge bg-success">{{lang('dashboard','video_statu_open')}}</span>
                        @else
                        <span class="badge bg-danger">{{lang('dashboard','video_statu_close')}}</span>
                        @endif
                    </li>
                </ul>
                <div class="action">
                    <a href="edit-video/{{ $video->id }}" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                        <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                    </a>
                    <a href="javascript:;" onclick="deleteVideo({{ $video->id }});" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                        <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-xl-5">
            <form action="" id="addVideoForm">
                <div class="pageMain">
                    <h2 class="subTitle">{{ lang('dashboard','add_video') }}</h2>
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
                                <input type="text" class="form-control" name="title[{{$lang->seo}}]" id="title_{{$lang->seo}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="">URL</label>
                        <input type="text" class="form-control" name="url">
                    </div>
                    <div class="form-group">
                        <label for="">Sıra <i>i</i></label>
                        <input type="text" class="form-control" placeholder="Sıra" name="order_id">
                    </div>
                    <div class="form-group">
                        <label for="">Durum</label>
                        <select name="statu" id="" class="form-control">
                            <option value="">Seçiniz...</option>
                            <option value="1">Açık</option>
                            <option value="0">Kapalı</option>
                        </select>
                    </div>
                </div>
                <div class="pageFooter">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="Kaydet"> Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#addVideoForm').on("submit",function (event){
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
        var formData = $("#addVideoForm").serialize();
        $.ajax({
            url: "add-video",
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
    function deleteVideo(ID){
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
                    url: "delete-video",
                    type: "post",
                    data: {
                        ID : ID,
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