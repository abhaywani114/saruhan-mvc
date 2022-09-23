@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','edit_page_category_title') }}</h1>
    </div>
    <form action="" id="editPageCategoryForm">
        <div class="pageMain">
            @if(count($langs) > 1)
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
            @endif
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
                        <label for="">{{lang('dashboard','input_title')}}</label>
                        <input type="text" class="form-control" id="title_{{$lang->seo}}" name="title[{{$lang->seo}}]" placeholder="{{lang('dashboard','input_title')}}" value="{{ $category_content[$lang->seo]['title'] }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_description_title')}}</label>
                        <textarea class="form-control" rows="3" name="content[{{$lang->seo}}]" id="" placeholder="{{lang('dashboard','input_description_placeholder')}}">{{ $category_content[$lang->seo]['content'] }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="">{{lang('dashboard','input_parent_category')}}</label>
                <select name="parent_id" id="" class="form-control">
                    <option value="0">Yok</option>
                    @if(!empty($category_list))
                    @foreach($category_list as $cat)
                    @if($cat['category_id'] != $ID)
                    <option value="{{$cat['category_id']}}" @if($cat['category_id'] == $parent_id) selected="selected" @endif>{{$cat['title']}}</option>
                    @endif
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="">{{lang('dashboard','input_order_title')}}</label>
                <input type="text" class="form-control" name="order_id" value="{!! $order_id !!}">
            </div>
            <div class="form-group">
                <label for="">{{lang('dashboard','input_statu_title')}}</label>
                <select name="statu" id="" class="form-control">
                    <option value="1" @if($statu == 1) selected="selected" @endif>{{lang('dashboard','input_statu_open')}}</option>
                    <option value="0" @if($statu == 0) selected="selected" @endif >{{lang('dashboard','input_statu_close')}}</option>
                </select>
            </div>
        </div>
        <div class="pageFooter">
            <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    $("#editPageCategoryForm").on("submit",function (event){
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
        var formData = $("#editPageCategoryForm").serialize();
        $.ajax({
            url: "{{$ID}}",
            type: "post",
            cache: false,
            data: formData,
            beforeSend: function() {
                $(".pageFooter button").attr("disabled","disabled");
                Swal.fire({
                    imageUrl: '{{ get_asset("img/icons/loader.gif") }}',
                    imageWidth: 40,
                    imageHeight: 40,
                    showConfirmButton: false,
                })
            },
            success: function(response) {
                var result = JSON.parse(response);
                var statu = result.statu;
                var title = result.title;
                var text = result.text;
                Swal.fire({
                    icon: statu,
                    title: title,
                    text: text,
                    showConfirmButton: false,
                    timerProgressBar:true,
                    timer: 2000
                })
                if(statu == "success")
                {
                    setTimeout(function(){
                        window.location.reload();
                    }, 2000);
                }
            },
            complete: function(){
                $(".pageFooter button").removeAttr("disabled","disabled");
            }
        });
        return false;
    })
</script>
@endsection