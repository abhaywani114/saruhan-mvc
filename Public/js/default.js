// Text Editor //
if($('#editor_tr').length){
    var editor_tr = new RichTextEditor("#editor_tr");
}
if($('#editor_en').length){
    var editor_en = new RichTextEditor("#editor_en");
}
if($('#editor_fr').length){
    var editor_fr = new RichTextEditor("#editor_fr");
}
// if($('#editor_nl').length){
//     var editor_nl = new RichTextEditor("#editor_nl");
// }
// if($('#editor_ru').length){
//     var editor_ru = new RichTextEditor("#editor_ru");
// }



$(document).ready(function() {
    $("input[name^=order_id]").keyup(function(){
        if (this.value.match(/[^0-9]/g)){
            this.value = this.value.replace(/[^0-9]/g,'');
        }
    })

    $('#langSelectAdmin').on('change', function () {
        var lang = $( this ).val();
        $.ajax({
            url: "/saruhanweb/set-admin-lang",
            type: "post",
            cache: false,
            data: {
                lang: lang
            },
            beforeSend: function() {
            },
            success: function(response) {
                window.location.reload(0);
            },
            complete: function(){
            }
        });
        return false;
    });
})