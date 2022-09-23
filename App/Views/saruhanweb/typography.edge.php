@extends('saruhanweb.master')
@section('content')
<div class="typography">
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Başlıklar</span>
                <h1>Başlık 1</h1>
                <h2>Başlık 2</h2>
                <h3>Başlık 3</h3>
                <h4>Başlık 4</h4>
                <h5>Başlık 5</h5>
                <h6>Başlık 6</h6>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Nav&Tab</span>
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

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Form</span>
                <div class="form-group">
                    <label for="">Input <i>i</i></label>
                    <input type="text" class="form-control" id="" placeholder="Input">
                    <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                </div>
                <div class="form-group">
                    <label for="">Select</label>
                    <select name="" id="" class="form-control">
                        <option value="">Option 1</option>
                        <option value="">Option 2</option>
                        <option value="">Option 3</option>
                        <option value="">Option 4</option>
                        <option value="">Option 5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Text Editör</span>
                <div class="form-group">
                    <label for="">Rich Text Editor</label>
                    <textarea name="" id="" class="editor"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Alert Box</span>
                <span class="alert-success">burak-malgaz.com.tr.jpeg Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque consequatur maxime nostrum optio quasi! Ab at, aut eius est eum ex explicabo facere id illo laborum neque nulla officiis quos.</span>
                <span class="alert-danger">burak-malgaz.com.tr.jpeg</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Table</span>
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
                    <tr>
                        <td class="text-center">---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>
                            @if( 1 == 1)
                            <span class="badge bg-success">{{lang('dashboard','input_statu_open')}}</span>
                            @else
                            <span class="badge bg-danger">{{lang('dashboard','input_statu_close')}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="actionBtn">
                                <a href="edit-__/ID" class="editBtn" title="{{lang('dashboard','t_action_edit')}}">
                                    <img src="{!! get_asset('img/icons/edit.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_edit')}}">
                                </a>
                                <a href="javascript:;" onclick="delete___(ID);" class="trashBtn" title="{{lang('dashboard','t_action_delete')}}">
                                    <img src="{!! get_asset('img/icons/trash.png') !!}" width="20px" height="20px" alt="{{lang('dashboard','t_action_delete')}}">
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">Badge</span>
                <span class="badge bg-primary">Primary</span>
                <span class="badge bg-secondary">Secondary</span>
                <span class="badge bg-success">Success</span>
                <span class="badge bg-danger">Danger</span>
                <span class="badge bg-warning text-dark">Warning</span>
                <span class="badge bg-info text-dark">Info</span>
                <span class="badge bg-light text-dark">Light</span>
                <span class="badge bg-dark">Dark</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <button class="btn btn-save">Kaydet</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="box">
                <span class="title">SweetAlert</span>
                <button onclick="successAlert();" class="btn btn-success">Başarılı Dönüş</button>
                <button onclick="errorAlert();" class="btn btn-danger">Hatalı Dönüş</button>
                <button onclick="warningAlert();" class="btn btn-warning">Uyarı Dönüş</button>
                <button onclick="infoAlert();" class="btn btn-info">Bilgilendirme Dönüş</button>
                <button onclick="questionAlert();" class="btn btn-primary">Sorgulu Dönüş</button>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function successAlert(){
        Swal.fire(
            'Güzel İş!',
            'Butona tıkaldın',
            'success'
        )
    }
    function errorAlert(){
        Swal.fire(
            'Güzel İş!',
            'Butona tıkaldın',
            'error'
        )
    }
    function warningAlert(){
        Swal.fire(
            'Güzel İş!',
            'Butona tıkaldın',
            'warning'
        )
    }
    function infoAlert(){
        Swal.fire(
            'Güzel İş!',
            'Butona tıkaldın',
            'info'
        )
    }
    function questionAlert(){
        Swal.fire(
            'Güzel İş!',
            'Butona tıkaldın',
            'question'
        )
    }
</script>