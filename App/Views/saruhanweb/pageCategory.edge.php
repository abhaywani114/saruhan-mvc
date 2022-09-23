@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','page_category_title')}}</h1>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <form action="" id="addPageCategoryForm">
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
                                <input type="text" class="form-control" id="title_{{$lang->seo}}" name="title[{{$lang->seo}}]" placeholder="{{lang('dashboard','input_title')}}">
                            </div>
                            <div class="form-group">
                                <label for="">{{lang('dashboard','input_description_title')}}</label>
                                <textarea class="form-control" rows="3" name="content[{{$lang->seo}}]" id="content_{{$lang->seo}}" placeholder="{{lang('dashboard','input_description_placeholder')}}"></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_parent_category')}}</label>
                        <select name="parent_id" id="" class="form-control">
                            <option value="">{{lang('dashboard','input_choose')}}</option>
                            <option value="0">{{lang('dashboard','input_null')}}</option>
                            @if(!empty($category_list))
                            @foreach($category_list as $cat)
                            <option value="{{$cat['category_id']}}">{{$cat['title']}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_order_title')}}</label>
                        <input type="text" class="form-control" name="order_id" maxlength="11">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_statu_title')}}</label>
                        <select name="statu" id="" class="form-control">
                            <option value="">{{lang('dashboard','input_choose')}}</option>
                            <option value="1">{{lang('dashboard','input_statu_open')}}</option>
                            <option value="0">{{lang('dashboard','input_statu_close')}}</option>
                        </select>
                    </div>
                </div>
                <div class="pageFooter">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
                </div>
            </form>
        </div>
        <div class="col-xl-8">
            @if(!empty($categories))
            <table class="pageTable">
                <thead>
                <tr>
                    <th class="first_col">ID</th>
                    <th>Başlık</th>
                    <th>Kategori</th>
                    <th>Sıra</th>
                    <th>Durum</th>
                    <th width="100px">İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="text-center">{{$category->category_id}}</td>
                    <td>{{$category->title}}</td>
                    <td>{{$category->parent_id}}</td>
                    <td>{{$category->order_id}}</td>
                    <td>
                        @if($category->statu == 1)
                        <span class="badge bg-success">{{lang('dashboard','input_statu_open')}}</span>
                        @else
                        <span class="badge bg-danger">{{lang('dashboard','input_statu_close')}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="actionBtn">
                            <a href="edit-page-category/{{$category->category_id}}" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                                <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                            </a>
                            <a href="javascript:;" onclick="deletePageCategory({{$category->category_id}});" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                                <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <div class="noContent">
                {{lang('dashboard','no_content')}}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $("#addPageCategoryForm").on("submit",function (event){
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
        var parent_id = $(".parent_id").val();
        if (parent_id == "")
        {
            $(".parent_id").focus();
            return false;
        }
        var statu = $(".statu").val();
        if (statu == "")
        {
            $(".statu").focus();
            return false;
        }
        var formData = $("#addPageCategoryForm").serialize();
        $.ajax({
            url: "add-page-category",
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
    function deletePageCategory(ID){
        var yesBtn = "{{lang('dashboard','yes_btn')}}";
        var noBtn = "{{lang('dashboard','no_btn')}}";
        var msg = "{{lang('dashboard','delete_query')}}";
        var title = "{{lang('dashboard','question_title')}}";
        Swal.fire({
            icon: 'question',
            title: title,
            text: msg,
            showCancelButton:true,
            cancelButtonText: noBtn,
            confirmButtonText: yesBtn,
            preConfirm: () => {
                $.ajax({
                    url: "delete-page-category",
                    type: "post",
                    data: {
                        ID : ID,
                    },
                    success: function(response) {
                        var parse = JSON.parse(response);
                        var statu = parse.statu;
                        var title = parse.title;
                        var text = parse.text;
                        Swal.fire({
                            position: 'center',
                            icon: statu,
                            title: title,
                            text: text,
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