<?php
require_once("mysql.php");
$id = $_GET["id"];
$sth = mysqli_query($con,"SELECT lastname,firstname,club,category FROM futok WHERE id=$id");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

mysqli_close($con);

?>