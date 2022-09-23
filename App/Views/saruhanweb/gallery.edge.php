@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','gallery_title') }}</h1>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <div class="viewsButttons">
                <ul>
                    <li><button><img src="{!! get_asset('img/icons/list-1.png') !!}" width="25px" height="25px" alt=""></button></li>
                    <li><button><img src="{!! get_asset('img/icons/list-2.png') !!}" width="25px" height="25px" alt=""></button></li>
                </ul>
            </div>
            <div class="mediaGalleryMain">
                <ul>
                    @forelse($gallery as $gVal)
                    <li>
                        
                        <div class="box">
                            <div class="box-top">
                                <span class="viewBtn">
                                    <a href="edit-gallery/{{ $gVal->gallery_id }}">
                                        <img src="{!! get_asset('img/icons/eye.png') !!}" width="20px" height="20px" alt="">
                                    </a>
                                </span>
                                <span class="trashBtn">
                                    <a href="javascript:;" >
                                        <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="">
                                    </a>
                                </span>
                            </div>
                            <a href="edit-gallery/{{ $gVal->gallery_id }}">
                                <img src="{!! get_asset('upload/'.$gVal->name) !!}" alt="" width="105px" height="105px" class="img">
                            </a>
                        </div>
                        
                    </li>
                    @empty
                        Hiç görsel eklenmemiş!
                    @endforelse
                </ul>
            </div>
            <div class="mediaListMain">
                <ul>
                    @forelse($gallery as $gVal)
                    <li>
                        <a href="edit-gallery/{{ $gVal->gallery_id }}">
                            <div class="box">
                                <a href="edit-gallery/{{ $gVal->gallery_id }}">
                                    <img src="{!! get_asset('upload/'.$gVal->name) !!}" alt="" width="105px" height="105px" class="img">
                                </a>
                                <span class="boxTitle"></span>
                                <span class="mediaSize1">Diskdeki Boyut</span>
                                <span class="mediaSize2">Px cinsinden uzunluğu</span>
                                <div>
                                    <span class="viewBtn">
                                        <img src="{!! get_asset('img/icons/eye.png') !!}" width="20px" height="20px" alt="">
                                    </span>
                                    <span class="trashBtn">
                                        <a href="javascript:;" >
                                            <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="">
                                        </a>
                                    </span>
                                </div>
                                
                            </div>
                        </a>

                    </li>
                    @empty
                    Hiç görsel eklenmemiş!
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-xl-4">
            <form action="" id="addGalleryForm" enctype="multipart/form-data">
                <div class="pageMain">
                    <h2 class="subTitle">{{ lang('dashboard','add_gallery') }}</h2>
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
                                <label for="">{{ lang('dashboard','input_title') }}</label>
                                <input type="text" class="form-control" id="title_{{$lang->seo}}" name="title[{{$lang->seo}}]" placeholder="{{ lang('dashboard','input_title') }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="box boxDashed">
                        <div class="form-group">
                            <input type="file" class="form-control" name="file[]" multiple="multiple">
                            <p class="help-text">{{ lang('dashboard','file_mime') }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">{{ lang('dashboard','gallery_categories') }}</label>
                        <select name="category_id" id="" class="form-control">
                            <option value="">{{ lang('dashboard','input_choose') }}</option>
                            @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @empty
                            @endforelse
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
    $(document).ready(function (){
        $("#addGalleryForm").on("submit",function (event){
            event.preventDefault();
            // title
            var titleCount = $('input[name^=title]').length;
            var titleNum = 0;
            $('input[name^=title]').each( (index, element) => {
                var id = $('input[name^=title]:eq('+index+')').attr('id');
                var idEx = id.split("_");
                var locale = idEx[1];
                var val = $('input[name^=title]:eq('+index+')').val();
                if (val == "")
                {
                    $(".pageMain .nav .nav-link").removeClass('active');
                    $(".pageMain .nav .nav-link").attr('aria-selected', 'false');
                    $(".pageMain .nav #nav-" + locale + "-tab").addClass('active');
                    $(".pageMain .nav #nav-" + locale + "-tab").attr('aria-selected', 'true');
                    $(".pageMain .tab-content .tab-pane").removeClass('active show');
                    $(".pageMain .tab-content #nav-"+locale).addClass('active show');
                    $('input[name^=title]:eq(' + index + ')').focus();
                    return false;
                }
                else
                {
                    //console.log(index, id, val, locale);
                }
                titleNum++;
            });
            if (titleNum != titleCount)
            {
                return false;
            }
            // file
            var file = $('input[name^=file]').val();
            if (file == ""){
                $('input[name^=file]').focus();
                return false;
            }
            // category
            var category = $('select[name^=category_id]').val();
            if (category == ""){
                $('select[name^=category_id]').focus();
                return false;
            }
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "add-gallery",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                beforeSend: function() {
                    $(".pageFooter button").attr('disabled','disapled');
                    Swal.fire({
                        title: '<img src="{{ get_asset("img/icons/loader.gif") }}" width="40px" height="auto">',
                        showConfirmButton: false,
                        allowOutsideClick:false,
                    })
                },
                success: function(response) {
                    // console.log(response)
                    var result = JSON.parse(response);
                    var statu = result.statu;
                    var title = result.title;
                    var content = result.content;
                    Swal.fire({
                        // icon: statu,
                        title: title,
                        html: content,
                        confirmButtonColor: '#e04eca',
                        confirmButtonText: 'Tamam',
                        allowOutsideClick:false,
                    }).then((result) => {
                        if(statu == "success")
                        {
                            window.location.reload(0);
                        }
                        else{
                            $(".pageFooter button").removeAttr('disabled','disapled');
                        }
                    })
                },
                complete: function(){
                }
            });
        })
    })
</script>
@endsection