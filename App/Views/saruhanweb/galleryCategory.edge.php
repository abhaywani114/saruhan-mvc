@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{ lang('dashboard','gallery_category') }}</h1>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <form action="" id="addGalleryCategoryForm">
                <div class="pageMain">
                    <h2 class="subTitle">{{ lang('dashboard','add_gallery_category') }}</h2>
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
                                <input type="text" class="form-control" placeholder="{{ lang('dashboard','input_title') }}" name="title[{{$lang->seo}}]" id="title_{{ $lang->seo }}">
                            </div>
                            <div class="form-group">
                                <label for="">{{ lang('dashboard','input_description_title') }}</label>
                                <textarea name="description[{{$lang->seo}}]" id="" rows="4" class="form-control" placeholder="{{ lang('dashboard','input_description_title') }}"></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="">{{ lang('dashboard','input_parent_category') }}</label>
                        <select name="parent_id" id="" class="form-control">
                            <option value="">{{ lang('dashboard','input_choose') }}</option>
                            <option value="0">{{ lang('dashboard','input_null') }}</option>
                            @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{ lang('dashboard','input_order_title') }}</label>
                        <input type="text" class="form-control" placeholder="{{ lang('dashboard','input_order_title') }}" name="order_id">
                    </div>
                    <div class="form-group">
                        <label for="">{{ lang('dashboard','input_statu_title') }}</label>
                        <select name="statu" id="" class="form-control">
                            <option value="">{{ lang('dashboard','input_choose') }}</option>
                            <option value="1">{{ lang('dashboard','input_statu_open') }}</option>
                            <option value="0">{{ lang('dashboard','input_statu_close') }}</option>
                        </select>
                    </div>
                </div>
                <div class="pageFooter">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="Kaydet"> Kaydet</button>
                </div>
            </form>
        </div>
        <div class="col-xl-8">
            @if(!empty($categories))
            <table class="pageTable">
                <thead>
                <tr>
                    <th class="first_col">ID</th>
                    <th>{{ lang('dashboard','t_title') }}</th>
                    <th>{{ lang('dashboard','t_parent_title') }}</th>
                    <th>{{ lang('dashboard','t_order_title') }}</th>
                    <th>{{ lang('dashboard','t_statu_title') }}</th>
                    <th width="100px">{{ lang('dashboard','t_action_title') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="text-center">{{ $category->id }}</td>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->parent }}</td>
                    <td>{{ $category->order_id }}</td>
                    <td>
                        @if( $category->statu == 1)
                        <span class="badge bg-success">{{lang('dashboard','input_statu_open')}}</span>
                        @else
                        <span class="badge bg-danger">{{lang('dashboard','input_statu_close')}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="actionBtn">
                            <a href="edit-gallery-category/{{ $category->id }}" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                                <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                            </a>
                            <a href="javascript:;" onclick="deleteGalleryCategory({{ $category->id }});" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                                <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $("#addGalleryCategoryForm").on("submit",function (event){
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
        var formData = $("#addGalleryCategoryForm").serialize();
        $.ajax({
            url: "add-gallery-category",
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

    function deleteGalleryCategory(ID){
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
                    url: "delete-gallery-category",
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