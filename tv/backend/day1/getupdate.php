<?php
require_once("../mysql.php");
$v = $_GET["v"];
$sth = mysqli_query($con,"SELECT id,version FROM updated_1 WHERE version>=$v");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $sth2 = mysqli_query($con,"SELECT start,time,status FROM nap_1 WHERE id=".$r["id"]);
    $r2 = mysqli_fetch_assoc($sth2);
    $r2["id"] = $r["id"];
    $r2["version"] = $r["version"];
    $rows[] = $r2;
}

print json_encode($rows);
mysqli_close($con);
?>