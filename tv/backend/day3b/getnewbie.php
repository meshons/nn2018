<?php
require_once("../mysql.php");
$id = $_GET["v"];
$sth = mysqli_query($con,"SELECT id,start,time,status,version FROM nap_3 WHERE version>=$id");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $sth2 = mysqli_query($con,"SELECT category,lastname,firstname,club FROM futok WHERE id=".$r["id"]);
    $r2 = mysqli_fetch_assoc($sth2);
    $r["category"] = mb_convert_encoding($r2["category"], "UTF-8", "Windows-1252");
    $r["firstname"] = mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252");
    $r["lastname"] = mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252");
    $r["club"] = mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252");
    $sth3 = mysqli_query($con,"SELECT time,status FROM nap_1 WHERE id=".$r["id"]);
    if($r3 = mysqli_fetch_assoc($sth3)){
    $sth4 = mysqli_query($con,"SELECT time,status FROM nap_2 WHERE id=".$r["id"]);
    if($r4 = mysqli_fetch_assoc($sth4)){

    $r["alltime"]=$r["time"];
    if($rr["status"]==0 && $r3["status"]==0 && $r4["status"]==0){
        $r["time"] = $r["alltime"]+$r3["time"]+$r4["time"];
        $r["status"]=0;
    }else{
        $r["status"]=100;
        $r["time"]="";
    }
}else{
    $r["status"]=100;
    $r["alltime"]=$r["time"];
    $r["time"]="";
}
    }else{
        $r["status"]=100;
        $r["alltime"]=$r["time"];
        $r["time"]="";
    }

    $rows[] = $r;
}
print json_encode($rows);

mysqli_close($con);
?>