@extends('saruhanweb.master')
@section('content')
<div class="page">
    <div class="pageHeader">
        <h1 class="pageTitle">{{lang('dashboard','pages_title')}}</h1>
    </div>
    <div>
        @if(!empty($pages))
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
            @foreach($pages as $page)
            <tr>
                <td class="text-center">{{ $page->page_id }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->category }}</td>
                <td>{{ $page->order_id }}</td>
                <td>
                    @if( $page->statu == 1)
                    <span class="badge bg-success">{{lang('dashboard','input_statu_open')}}</span>
                    @else
                    <span class="badge bg-danger">{{lang('dashboard','input_statu_close')}}</span>
                    @endif
                </td>
                <td>
                    <div class="actionBtn">
                        <a href="edit-page/{{$page->page_id}}" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                            <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                        </a>
                        <a href="javascript:;" onclick="deletePage({{$page->page_id}});" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                            <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                        </a>
                    </div>
                </td>
            </tr>
            </tbody>
            @endforeach
        </table>
        @else
        <div class="noContent">
            {{lang('dashboard','no_content')}}
        </div>
        @endif
    </div>
</div>
@endsection
@section('js')
<script>
    function deletePage(ID){
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
                    url: "delete-page",
                    type: "post",
                    cache: false,
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