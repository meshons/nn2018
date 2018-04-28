
function t(s) {
    if (s >= 3600)
      return Math.floor(s / 3600) % 60 + ':' +
        (Math.floor(s / 60) % 60 > 9 ? Math.floor(s / 60) % 60 :
          '0' + Math.floor(s / 60) % 60) +
        ':' + (s % 60 > 9 ? s % 60 : '0' + s % 60);
    else if (s >= 60)
      return Math.floor(s / 60) % 60 + ':' + (s % 60 > 9 ? s % 60 : '0' + s % 60);
    else
      return s;
  }


function getSplit(id,nap){
    $.getJSON('nn2018/backend/getsplit.php?id=' + id+'&nap='+nap, function (data) {
        /*$.each(data, function (key, val) {
        });*/
        console.log(data);
        var res = $("body").find("tr#"+id);
        $("<splittimes id='"+id+"' class='mx-auto' style='display:block;'>").insertAfter(res);
        var split =res.next("splittimes");
        var i=1;
        split.append("<table class='table table-striped'>")
        var table = split.find("table");
        var pre=0;
        while(data[0]["checknr"+i]!=0){
            table.append("<tr><td>"+i+"</td><td>"+t(parseInt(data[0]["check"+i],10))+"</td><td>+"+t(parseInt(data[0]["check"+i],10) - pre)+"</td></tr>");
            pre = parseInt(data[0]["check"+i],10);

            i++;
        }
    });
}

function openClose(id,nap){
    if($("body").find("splittimes#"+id).length==0)
        getSplit(id,nap);
    else{
        $("body").find("splittimes#"+id).toggle();
        console.log("x");
    }
}