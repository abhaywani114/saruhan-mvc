@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','edit_user_title')}}</h1>
    </div>
    <form action="" id="editUserForm">
        <div class="pageMain">
            <div class="row">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_nickname')}}</label>
                        <input type="text" name="nickname" class="form-control" placeholder="{{lang('dashboard','input_nickname')}}" value="{{ $user->nickname }}">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_name')}}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{lang('dashboard','input_name')}}" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_surname')}}</label>
                        <input type="text" name="surname" class="form-control" placeholder="{{lang('dashboard','input_surname')}}" value="{{ $user->surname }}">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_email')}}</label>
                        <input type="text" name="email" class="form-control" placeholder="{{lang('dashboard','input_email')}}" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_password')}}</label>
                        <input type="text" name="password1" class="form-control" placeholder="{{lang('dashboard','input_password')}}">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_password_again')}}</label>
                        <input type="text" name="password2" class="form-control" placeholder="{{lang('dashboard','input_password_again')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="pageFooter">
            <div class="col-xl-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    $('#editUserForm').on("submit",function (event){
        event.preventDefault();
        //nickname
        var nickname = $('input[name^=nickname]').val();
        if (nickname == "")
        {
            $('input[name^=nickname]').focus();
            return false;
        }
        //password
        var newpassword = $('input[name^=password1]').val();
        //password_again
        var password2 = $('input[name^=password2]').val();
        if (newpassword != password2)
        {
            if (newpassword != password2)
            {
                Swal.fire({
                    icon: 'warning',
                    title:'Girmiş olduğunuz şifreler eşleşmiyor!',
                    showConfirmButton: true,
                })
                return false;
            }
        }
        var formData = $("#editUserForm").serialize();
        $.ajax({
            url: "{{$user->id}}",
            type: "post",
            cache: false,
            data: formData,
            beforeSend: function() {
                Swal.fire({
                    title: '<img src="{{ get_asset("img/icons/loader.gif") }}" width="40px" height="auto">',
                    showConfirmButton: false,
                })
            },
            success: function(response) {
                // console.log(response);
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