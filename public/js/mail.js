$(document).ready(function(){
    $('.btn-outline-success').on('click', function () {
        var id = this.id;
        var token = $("meta[name='csrf-token']").attr('content');
        console.log(id + " / " + name);
        var req = $.ajax({
            url: '/admin/create-from-mail',
            type: 'POST',
            data: {"id":id,"token":token},
            dataType: 'json',
            success: function(res) {
                console.log('закончили');
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
});