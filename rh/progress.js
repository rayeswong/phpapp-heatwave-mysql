$('document').ready(function () {
    $('#startInsert').click(function () {
        getProgress();
        console.log('startInsert');
        $.ajax({
            url: "insert.php",
            type: "POST",
            data: {
                'rows': '10000'
            },
            async: true, //IMPORTANT!
            contentType: false,
            processData: false,
            success: function(data){
                if(data!==''){
                    alert(data);
                }
                return false;
            }
        });
        return false;
    });

});

function getProgress() {
    console.log('getProgress');
    $.ajax({
        url: "getProgress.php",
        type: "GET",
        contentType: false,
        processData: false,
        async: false,
        success: function (data) {
            console.log(data);
            $('#progressbar').css('width', data+'%').children('.sr-only').html(data+"% Complete");
            if(data!=='100'){
                setTimeout('getProgress()', 200);
            }
        }
    });
}
