@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','edit_gallery') }}</h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <form action="" id="editGalleryForm">
            <div class="gallery-page">
                <div class="gallery-page-body">
                    <div class="pMain">
                        <div class="left">
                            <img src="{{ get_asset('upload/'.$gallery->name)}}" alt="" >
                        </div>
                        <div class="right">
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
                                        <input type="text" class="form-control" id="title_{{$lang->seo}}" name="title[{{$lang->seo}}]" placeholder="{{ lang('dashboard','input_title') }}" value="{{ $gallery->content[$lang->seo]['title'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Açıklama</label>
                                        <textarea name="description[{{$lang->seo}}]" class="form-control" id="" cols="30" rows="3">{{ $gallery->content[$lang->seo]['description'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">URL</label>
                                        <input type="text" class="form-control" name="url[{{$lang->seo}}]" value="{{ $gallery->content[$lang->seo]['url'] }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="">{{ lang('dashboard','gallery_categories') }}</label>
                                <select name="category_id" id="" class="form-control">
                                    @forelse($categories as $category)
                                    <option value="{{ $category->id }}" @if($gallery->category_id == $category->id) selected="selected" @endif >{{ $category->title }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Sıra</label>
                                <input type="text" class="form-control" name="order_id" value="{{ $gallery->order_id }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="Kaydet"> Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function (){
        $("#editGalleryForm").on("submit",function (event){
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

            var formData = $("#editGalleryForm").serialize();
            $.ajax({
                url: "{{$gallery->gallery_id}}",
                type: "post",
                data: formData,
                cache: false,
                beforeSend: function() {
                    $(".pageFooter button").attr('disabled','disapled');
                    Swal.fire({
                        title: '<img src="{{ get_asset("img/icons/loader.gif") }}" width="40px" height="auto">',
                        showConfirmButton: false,
                    })
                },
                success: function(response) {
                    console.log(response)
                    var result = JSON.parse(response);
                    var statu = result.statu;
                    var title = result.title;
                    var content = result.content;
                    Swal.fire({
                        icon: statu,
                        title: title,
                        html: content,
                        confirmButtonColor: '#e04eca',
                        confirmButtonText: 'Tamam',
                    }).then((result) => {
                        location.reload();
                    })
                },
                complete: function(){
                }
            });
        })

    })

</script>
@endsection