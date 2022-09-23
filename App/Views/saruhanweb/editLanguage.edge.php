@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','languages_edit_title')}}</h1>
    </div>
    <div class="pageMain">
        <form action="" id="editLanguageForm">
            <div class="row">
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_title')}}</label>
                        <input type="text" class="form-control title" name="title" placeholder="{{lang('dashboard','input_title')}}" value="{{$title}}">
                        <p class="help-text">{{lang('dashboard','input_required')}}</p>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_seo_title')}}</label>
                        <input type="text" class="form-control seo" name="seo" placeholder="{{lang('dashboard','input_seo_title')}}" value="{{$seo}}">
                        <p class="help-text">{{lang('dashboard','input_required')}}</p>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_locale_title')}}</label>
                        <input type="text" class="form-control locale" name="locale" placeholder="{{lang('dashboard','input_locale_title')}}" value="{{$locale}}">
                        <p class="help-text">{{lang('dashboard','input_required')}}</p>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_statu_title')}}</label>
                        <select name="statu" id="" class="form-control statu">
                            <option value="1" @if($statu == 1) selected="selected" @endif>{{lang('dashboard','input_statu_open')}}</option>
                            <option value="0" @if($statu == 0) selected="selected" @endif>{{lang('dashboard','input_statu_close')}}</option>
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
</div>
@endsection
@section('js')
<script>
    $("#editLanguageForm").on("submit",function (event){
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
        var formData = $("#editLanguageForm").serialize();
        $.ajax({
            url: "{{$ID}}",
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
</script>
@endsection