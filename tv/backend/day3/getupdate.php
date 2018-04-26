<?php
require_once("../mysql.php");
$v = $_GET["v"];
$sth = mysqli_query($con,"SELECT id,version FROM updated_2 WHERE version>=$v");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $sth2 = mysqli_query($con,"SELECT start,time,status FROM nap_2 WHERE id=".$r["id"]);
    $r2 = mysqli_fetch_assoc($sth2);
    $r2["id"] = $r["id"];
    $r2["version"] = $r["version"];
    $sth3 = mysqli_query($con,"SELECT time,status FROM nap_1 WHERE id=".$r["id"]);
    $r3 = mysqli_fetch_assoc($sth3);
    $sth4 = mysqli_query($con,"SELECT time,status FROM nap_2 WHERE id=".$r["id"]);
    $r4 = mysqli_fetch_assoc($sth4);
    $r2["alltime"]="";
    if($r2["status"]==0 && $r3["status"]==0 && $r4["status"]==0){
        $r2["alltime"]=$r2["time"]+$r3["time"]+$r4["time"];
    }else{
        $r2["alltime"]="";
    }
    $rows[] = $r2;
}

print json_encode($rows);
mysqli_close($con);
?>