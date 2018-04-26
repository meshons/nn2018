<?php
require_once("mysql.php");
$id = $_GET["id"];
$day = $_GET["nap"];
$sth = mysqli_query($con,"SELECT * FROM $day WHERE id=$id");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

?>