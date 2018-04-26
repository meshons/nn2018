<?php
require_once("../mysql.php");
$sth = mysqli_query($con,"SELECT MAX(version) AS newbiever FROM nap_1;");
$rows = array();
$r = mysqli_fetch_assoc($sth);
$rows["newbie"]=$r["newbiever"];
print json_encode($rows);
mysqli_close($con);
?>