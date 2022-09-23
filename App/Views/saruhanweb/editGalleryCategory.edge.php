@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','edit_gallery_category') }}</h1>
    </div>
    <form action="" id="editGalleryCategoryForm">
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
                        <label for="">{{ lang('dashboard','input_title') }}</label>
                        <input type="text" class="form-control" placeholder="{{ lang('dashboard','input_title') }}" name="title[{{$lang->seo}}]" id="title_{{ $lang->seo }}" value="{{ $content[$lang->seo]['title'] }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ lang('dashboard','input_description_title') }}</label>
                        <textarea name="description[{{$lang->seo}}]" id="" rows="4" class="form-control" placeholder="{{ lang('dashboard','input_description_title') }}">{{ $content[$lang->seo]['description'] }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="">{{ lang('dashboard','input_parent_category') }}</label>
                <select name="parent_id" id="" class="form-control">
                    <option value="0" @if($parent_id == 0) selected="selected" @endif >{{ lang('dashboard','input_null') }}</option>
                    @forelse($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == $parent_id) selected="selected" @endif >{{ $category->title }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="form-group">
                <label for="">{{ lang('dashboard','input_order_title') }}</label>
                <input type="text" class="form-control" placeholder="{{ lang('dashboard','input_order_title') }}" name="order_id" value="{{ $order_id }}">
            </div>
            <div class="form-group">
                <label for="">{{ lang('dashboard','input_statu_title') }}</label>
                <select name="statu" id="" class="form-control">
                    <option value="1" @if($statu == 1) selected="selected" @endif >{{ lang('dashboard','input_statu_open') }}</option>
                    <option value="0" @if($statu == 0) selected="selected" @endif>{{ lang('dashboard','input_statu_close') }}</option>
                </select>
            </div>
        </div>
        <div class="pageFooter">
            <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="Kaydet"> Kaydet</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    $("#editGalleryCategoryForm").on("submit",function (event){
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
        //parent_id
        var parent_id = $('select[name^=parent_id]').val();
        if (parent_id == "")
        {
            $('select[name^=parent_id]').focus();
            return false;
        }
        // statu
        var statu = $('select[name^=statu]').val();
        if (statu == "")
        {
            $('select[name^=statu]').focus();
            return false;
        }
        var formData = $("#editGalleryCategoryForm").serialize();
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
                console.log(response)
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