<?php
require_once("mysql.php");
$id = $_GET["v"];
$sth = mysqli_query($con,"SELECT id FROM updated_1 WHERE version=$id");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

mysqli_close($con);
?>