$(document).ready(function(){
    $('#reg-button').on('click', function () {
        var arr = $('#form-register').serializeArray();
        var token = {
            name : 'token',
            value: $("meta[name='csrf-token']").attr('content'),
        };
        arr.push(token);
        $.ajax({
            url: '/main/register',
            type: 'POST',
            data: arr,
            dataType: "json",
            success: function(resp) {
                        $(location).attr('href','/main/index');
                        console.log(resp);
                        if ( resp.error ) {
                            console.log( 'error : ' + resp.error );
                        }
            },
            error: function (err) {
                console.log("Error: " + err);
            },
        });
    });

    var entropizer = $(function(){
        $('#meter').entropizer({
            target: '#id-psw',
            buckets: [
                { max: 45, strength: 'слабый', color: '#e13' },
                { min: 45, max: 60, strength: 'подойдет', color: '#f80' },
                { min: 60, max: 75, strength: 'хороший', color: '#8c0' },
                { min: 75, strength: 'отличный', color: '#0c8' }
            ],
            update: function(data, ui) {
                ui.bar.css({
                    'background-color': data.color,
                    'width': data.percent + '%'
                });
                ui.text.html(data.strength);
            },
        });
    });

});