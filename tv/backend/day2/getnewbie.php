<?php
require_once("../mysql.php");
$id = $_GET["v"];
$sth = mysqli_query($con,"SELECT id,start,time,status,version FROM nap_2 WHERE version>=$id");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $sth2 = mysqli_query($con,"SELECT category,lastname,firstname,club FROM futok WHERE id=".$r["id"]);
    $r2 = mysqli_fetch_assoc($sth2);
    $r["category"] = mb_convert_encoding($r2["category"], "UTF-8", "Windows-1252");
    $r["firstname"] = mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252");
    $r["lastname"] = mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252");
    $r["club"] = mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252");
    $sth3 = mysqli_query($con,"SELECT time,status FROM nap_1 WHERE id=".$r["id"]);
    $r3 = mysqli_fetch_assoc($sth3);
    $r["alltime"]="";

    if($r["status"]==0 && $r3["status"]==0){
        $r["alltime"]=$r["time"]+$r3["time"];
    }else{
        $r["alltime"]="";
    }

    $rows[] = $r;
}
print json_encode($rows);

mysqli_close($con);
?>