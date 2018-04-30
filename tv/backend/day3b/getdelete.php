<?php
require_once("../mysql.php");
$v = $_GET["v"];
$sth = mysqli_query($con,"SELECT id,version FROM deleted_3 WHERE version>=$v");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}

print json_encode($rows);
mysqli_close($con);
?>