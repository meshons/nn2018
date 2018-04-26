<?php
require_once("../mysql.php");
$sth = mysqli_query($con,"SELECT MAX(version) AS newbiever FROM night;");
$rows = array();
$r = mysqli_fetch_assoc($sth);
$rows["newbie"]=$r["newbiever"];
$sth = mysqli_query($con,"SELECT MAX(version) AS newbiever FROM updated_night;");
$r = mysqli_fetch_assoc($sth);
$rows["update"]=$r["newbiever"];
$sth = mysqli_query($con,"SELECT MAX(version) AS newbiever FROM deleted_night;");
$r = mysqli_fetch_assoc($sth);
$rows["delete"]=$r["newbiever"];
print json_encode($rows);
mysqli_close($con);
?>