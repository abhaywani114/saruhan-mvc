@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','languages_title')}}</h1>
    </div>
    <div class="pageMain">
        <h3 class="subTitle">{{lang('dashboard','languages_add_title')}}</h3>
        <form action="" id="addLanguageForm">
            <div class="row">
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_title')}}</label>
                        <input type="text" class="form-control title" name="title" placeholder="{{lang('dashboard','input_title')}}">
                        <p class="help-text">{{lang('dashboard','input_required')}}</p>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_seo_title')}}</label>
                        <input type="text" class="form-control seo" name="seo" placeholder="{{lang('dashboard','input_seo_title')}}">
                        <p class="help-text">{{lang('dashboard','input_required')}}</p>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_locale_title')}}</label>
                        <input type="text" class="form-control locale" name="locale" placeholder="{{lang('dashboard','input_locale_title')}}">
                        <p class="help-text">{{lang('dashboard','input_required')}}</p>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_statu_title')}}</label>
                        <select name="statu" id="" class="form-control statu">
                            <option value="">{{lang('dashboard','input_choose')}}</option>
                            <option value="1">{{lang('dashboard','input_statu_open')}}</option>
                            <option value="0">{{lang('dashboard','input_statu_close')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="pageMain">
        <h3 class="subTitle">{{lang('dashboard','languages_list_title')}}</h3>
        <table class="pageTable">
            <thead>
            <tr>
                <th class="first_col">{{lang('dashboard','t_ID')}}</th>
                <th>{{lang('dashboard','t_title')}}</th>
                <th>{{lang('dashboard','t_seo_title')}}</th>
                <th>{{lang('dashboard','t_locale_title')}}</th>
                <th>Site</th>
                <th>Admin</th>
                <th>{{lang('dashboard','t_statu_title')}}</th>
                <th width="100px">{{lang('dashboard','t_action_title')}}</th>
            </tr>
            </thead>
            <tbody>
            @if(empty($langs))
            @else
            @foreach($langs as $lang)
            <tr>
                <td class="text-center">{{ $lang->id }}</td>
                <td>{{ $lang->title }}</td>
                <td>{{ $lang->seo }}</td>
                <td>{{ $lang->locale }}</td>
                <td><a href="javascript:;" onclick="setSiteLang('{{ $lang->seo }}');" class="badge bg-secondary">{{ lang('dashboard','default') }}</a></td>
                <td><a href="javascript:;" onclick="setAdminLang('{{ $lang->seo }}');" class="badge bg-secondary">{{ lang('dashboard','default') }}</a></td>
                <td>
                    @if($lang->statu == 1)
                    <span class="badge bg-success">{{lang('dashboard','input_statu_open')}}</span>
                    @else
                    <span class="badge bg-danger">{{lang('dashboard','input_statu_close')}}</span>
                    @endif
                </td>
                <td>
                    <div class="actionBtn">
                        <a href="edit-language/{{$lang->id}}" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                            <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                        </a>
                        <a href="javascript:;" onclick="deleteLanguage({{$lang->id}});" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                            <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('js')
<script>
    $("#addLanguageForm").on("submit",function (event){
        event.preventDefault();
        var title = $('.title').val();
        if (title == "")
        {
            $('.title').attr('placeholder','{{lang('dashboard','input_title_warning')}}').focus();
            return false;
        }
        else
        {
            $('.title').attr('placeholder','{{lang('dashboard','input_title')}}');
        }
        var seo = $('.seo').val();
        if (seo == "")
        {
            $('.seo').attr('placeholder','{{lang('dashboard','input_seo_warning')}}').focus();
            return false;
        }
        else
        {
            $('.seo').attr('placeholder','{{lang('dashboard','input_seo_title')}}');
        }
        var locale = $('.locale').val();
        if (locale == "")
        {
            $('.locale').attr('placeholder','{{lang('dashboard','input_locale_warning')}}').focus();
            return false;
        }
        else
        {
            $('.locale').attr('placeholder','{{lang('dashboard','input_locale_title')}}');
        }
        var statu = $('.statu').val();
        if (statu == "")
        {
            $('.statu').focus();
            return false;
        }
        var formData = $("#addLanguageForm").serialize();
        $.ajax({
            url: "add-language",
            type: "post",
            data: formData,
            beforeSend: function() {
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
                    timer: 2000
                })
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            },
            complete: function(){
            }
        });
        return false;
    })
    function deleteLanguage(ID){
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
                    url: "delete-language",
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

    function setSiteLang(lang){
        var yesBtn = "{{lang('dashboard','yes_btn')}}";
        var noBtn = "{{lang('dashboard','no_btn')}}";
        var msg = "{{lang('dashboard','site_default_lang')}}";
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
                    url: "set-site-lang",
                    type: "post",
                    data: {
                        lang : lang,
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
                        if (statu == "success")
                        {
                            setTimeout(function(){
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((response) => {
            return false;
        })
        return false;
    }
    function setAdminLang(lang){
        var yesBtn = "{{lang('dashboard','yes_btn')}}";
        var noBtn = "{{lang('dashboard','no_btn')}}";
        var msg = "{{lang('dashboard','admin_default_lang')}}";
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
                    url: "set-admin-lang",
                    type: "post",
                    data: {
                        lang : lang,
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
                        if (statu == "success")
                        {
                            setTimeout(function(){
                                window.location.reload();
                            }, 2000);
                        }
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