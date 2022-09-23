<!doctype html>
<html>
<head>
    <title>Saruhan Web Ajans | Yönetim Paneli</title>
    <link rel="stylesheet" href="{!! get_asset('plugins/sweetAlert/sweetalert.css') !!}">
    <link rel="stylesheet" href="{!! get_asset('plugins/bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! get_asset('plugins/richtexteditor/rte_theme_default.css') !!}" />
    <link rel="stylesheet" href="{!! get_asset('css/saruhanweb.css') !!}">
</head>
<body>
<div class="container">
    <div class="col-xl-4 offset-xl-4">
        <div class="loginForm">
            <h2>{{ $login_title }}</h2>
            <p>{{ $info }}</p>
            <form action="" id="loginForm">
                <div class="form-group">
                    <input type="text" class="form-control nickname" name="nickname" placeholder="{{ $nickname }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control password" name="password" placeholder="{{ $password }}" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">{{ $login_btn }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{!! get_asset('plugins/jquery/jquery.js') !!}"></script>
<script src="{!! get_asset('plugins/sweetAlert/sweetalert.js') !!}"></script>
<script src="{!! get_asset('plugins/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! get_asset('js/default.js') !!}"></script>
<script>
    $("#loginForm").on("submit", function(event){
        event.preventDefault();
        var nickname = $(".nickname").val();
        if (nickname == "") {
            $(".nickname").attr("placeholder","{{ $nickname_warning }}").focus();
            return false;
        }
        else {
            $(".nickname").attr("placeholder","{{ $nickname }}");
        }
        var password = $(".password").val();
        if (password == "") {
            $(".password").attr("placeholder","{{ $password_warning }}").focus();
            return false;
        }
        else {
            $(".password").attr("placeholder","{{ $password }}");
        }
        var formData = $("#loginForm").serialize();
        $.ajax({
            url: "login",
            type: "post",
            data: formData,
            beforeSend: function() {
                $("#loginForm button").attr("disabled","disabled");
                Swal.fire({
                    imageUrl: '{{ get_asset("img/icons/loader.gif") }}',
                    imageWidth: 40,
                    imageHeight: 40,
                    imageAlt: 'Custom image',
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
                if (statu == "success")
                {
                    setTimeout(function () {
                        window.location.href = "saruhanweb";
                    },2000)
                }
            },
            complete: function(){
                $("#loginForm button").removeAttr("disabled","disabled");
            }
        });
        return false;
    });
</script>
</body>
</html>