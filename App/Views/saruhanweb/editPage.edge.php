@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','edit_page_title')}}</h1>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <form action="" id="editPageForm">
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
                                <input type="text" name="title[{{$lang->seo}}]" id="title_{{$lang->seo}}" class="form-control" placeholder="{{lang('dashboard','input_title')}}" value="{{ $content[$lang->seo]['title'] }}">
                                <p class="help-text">{{lang('dashboard','input_required')}}</p>
                            </div>
                            <div class="form-group" style="color:#000;">
                                <label for="">{{lang('dashboard','input_content_title')}}</label>
                                <textarea id="editor_{{$lang->seo}}" name="content[{{$lang->seo}}]" id="title_{{$lang->seo}}">
                                    {{ $content[$lang->seo]['content'] }}
                                </textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_category')}}</label>
                        <select name="category_id" id="" class="form-control">
                            <option value="0" @if($category_id == 0) selected="selected" @endif>{{lang('dashboard','input_null')}}</option>
                            @if(!empty($categories))
                            @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" @if($category_id == $category->category_id) selected="selected" @endif >{{ $category->title }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_order_title')}} <i>i</i></label>
                        <input name="order_id" type="text" class="form-control" placeholder="{{lang('dashboard','input_order_title')}}" value="{{ $order_id }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_statu_title')}}</label>
                        <select name="statu" id="" class="form-control">
                            <option value="1" @if($statu == 1) selected="selected" @endif>{{lang('dashboard','input_statu_open')}}</option>
                            <option value="0" @if($statu == 0) selected="selected" @endif>{{lang('dashboard','input_statu_close')}}</option>
                        </select>
                    </div>
                </div>
                <div class="pageFooter">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
                </div>
            </form>
        </div>
        <div class="col-xl-4">
            <div class="addTagBox">
                <h2 class="addTitle">{{lang('dashboard','tags_title')}}</h2>
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
                        <button class="nav-link {{$active}}" id="nav-{{$lang->seo}}-tab-tag" data-bs-toggle="tab" data-bs-target="#nav-{{$lang->seo}}-tag" type="button" role="tab" aria-controls="nav-{{$lang->seo}}-tag" aria-selected="{{$ariaSelect}}">{{$lang->title}}</button>
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
                    <div class="tab-pane fade {{$show}} {{$active}}" id="nav-{{$lang->seo}}-tag" role="tabpanel" aria-labelledby="nav-{{$lang->seo}}-tab-tag">
                        <div class="box">
                            <form action="" id="addTagForm">
                                <div class="form-group">
                                    <label for="">{{lang('dashboard','tags_title')}}</label>
                                    <textarea name="tags[{{$lang->seo}}]" rows="3" class="form-control"></textarea>
                                    <p class="help-text">{{lang('dashboard','tags_info')}}</p>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-save">{{lang('dashboard','add_tag_button')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $("#editPageForm").on("submit",function (event){
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
        var category_id = $('select[name^=category_id]').val();
        if (category_id == "")
        {
            $('select[name^=category_id]').focus();
            return false;
        }
        // statu
        var statu = $('select[name^=statu]').val();
        if (statu == "")
        {
            $('select[name^=statu]').focus();
            return false;
        }
        var formData = $("#editPageForm").serialize();
        $.ajax({
            url: "{{$page_id}}",
            type: "post",
            cache: false,
            data: formData,
            beforeSend: function() {
                $(".pageFooter button").attr('disabled','disapled');
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
                    timer:2000
                })
                if(statu == 'success')
                {
                    setTimeout(function(){
                        window.location.reload();
                    }, 2000);
                }
            },
            complete: function(){
                $(".pageFooter button").removeAttr('disabled','disapled');
            }
        });
        return false;
    })
</script>
@endsection