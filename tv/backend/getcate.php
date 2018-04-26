<?php
require_once("mysql.php");

if(isset($_GET['s'])){$id = $_GET['s'];
$table = $id?"right_cat_1":"left_cat_1";
$sth = mysqli_query($con,"SELECT id,cat FROM $table WHERE 1 ORDER BY id");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $r["cat"] = mb_convert_encoding($r["cat"], "UTF-8", "Windows-1252");
    $rows[] = $r;
}
print json_encode($rows);
}
mysqli_close($con);
?>