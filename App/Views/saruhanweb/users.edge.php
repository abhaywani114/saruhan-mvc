@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','users_title')}}</h1>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="pageMain">
                <h2 class="subTitle">{{lang('dashboard','add_user_title')}}</h2>
                <form action="" id="addUserForm">
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_nickname')}}</label>
                        <input type="text" name="nickname" class="form-control" placeholder="{{lang('dashboard','input_nickname')}}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_name')}}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{lang('dashboard','input_name')}}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_surname')}}</label>
                        <input type="text" name="surname" class="form-control" placeholder="{{lang('dashboard','input_surname')}}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_email')}}</label>
                        <input type="text" name="email" class="form-control" placeholder="{{lang('dashboard','input_email')}}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_password')}}</label>
                        <input type="text" name="password1" class="form-control" placeholder="{{lang('dashboard','input_password')}}">
                    </div>
                    <div class="form-group">
                        <label for="">{{lang('dashboard','input_password_again')}}</label>
                        <input type="text" name="password2" class="form-control" placeholder="{{lang('dashboard','input_password_again')}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-save"><img src="{!! get_asset('img/icons/save.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','button_save')}}"> {{lang('dashboard','button_save')}}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <table class="pageTable">
                <thead>
                <tr>
                    <th class="first_col">{{lang('dashboard','t_ID')}}</th>
                    <th>{{lang('dashboard','t_nickname')}}</th>
                    <th>{{lang('dashboard','t_name').' '.lang('dashboard','t_surname')}}</th>
                    <th>{{lang('dashboard','t_email')}}</th>
                    <th>{{lang('dashboard','t_statu')}}</th>
                    <th width="100px">{{lang('dashboard','t_action_title')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td>{{ $user->nickname }}</td>
                    <td>{{ $user->name.' '.$user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if( $user->statu == 1)
                        <span class="badge bg-success">{{lang('dashboard','input_statu_open')}}</span>
                        @else
                        <span class="badge bg-danger">{{lang('dashboard','input_statu_close')}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="actionBtn">
                            <a href="edit-user/{{$user->id}}" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                                <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                            </a>
                            <a href="javascript:;" onclick="deleteUser({{$user->id}});" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                                <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#addUserForm').on("submit",function (event){
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
        if (newpassword == "")
        {
            $('input[name^=password1]').focus();
            return false;
        }
        //password_again
        var password2 = $('input[name^=password2]').val();
        if (password2 == "")
        {
            $('input[name^=password2]').focus();
            return false;
        }
        if (newpassword != password2)
        {
            Swal.fire({
                icon: 'warning',
                title:'Girmiş olduğunuz şifreler eşleşmiyor!',
                showConfirmButton: true,
            })
            return false;
        }
        var formData = $("#addUserForm").serialize();
        $.ajax({
            url: "add-user",
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
    function deleteUser(ID){
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
                    url: "delete-user",
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