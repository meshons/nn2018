<?php
require_once("../mysql.php");
$cat = $_GET["cat"];
$cat = mb_convert_encoding($cat, "Windows-1252", "UTF-8");
mysqli_query($con,"SET CHARACTER SET latin1");
$sth = mysqli_query($con,"SELECT id,firstname,lastname,club FROM futok_n WHERE category='".$cat."'");
$rows = array();
/*if (!$sth) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}*/
while($r = mysqli_fetch_assoc($sth)) {
    $rr = array();
    //echo $r["id"];
    $rr["id"] = $r["id"];
    $id=$r["id"];
    $rr["firstname"] = mb_convert_encoding($r["firstname"], "UTF-8", "Windows-1252");
    $rr["lastname"] = mb_convert_encoding($r["lastname"], "UTF-8", "Windows-1252");
    $rr["club"] = mb_convert_encoding($r["club"], "UTF-8", "Windows-1252");

    $sth2 = mysqli_query($con,"SELECT start,time,status FROM night WHERE id=$id");
    while($r2 = mysqli_fetch_assoc($sth2)) {
        $rr["start"] = $r2["start"];
        $rr["time"] = $r2["time"];
        $rr["status"] = $r2["status"];
        //$rr["version"] = $r2["version"];
    }
    //array_map("utf8_encode", $rr);
    if(isset($rr["start"]))$rows[] = $rr;
}
print json_encode($rows);

mysqli_close($con);

?>  