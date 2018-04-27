function getSplit(id){
    $.getJSON('nn2018/backend/getsplit.php?id=' + id+'&nap=nap_1', function (data) {
        /*$.each(data, function (key, val) {
        });*/
        //console.log(data[0]);
        var res = $("body").find("#"+id);
        
    });
}

function openClose(id){
    getSplit(id);
}