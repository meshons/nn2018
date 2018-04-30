<?php
require_once("../mysql.php");
$cat = $_GET["cat"];
$cat = mb_convert_encoding($cat, "Windows-1252", "UTF-8");
mysqli_query($con,"SET CHARACTER SET latin1");
$sth = mysqli_query($con,"SELECT id,firstname,lastname,club FROM futok WHERE category='".$cat."'");
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

    $sth2 = mysqli_query($con,"SELECT start,time,status FROM nap_2 WHERE id=$id");
    $r2 = mysqli_fetch_assoc($sth2);
        $rr["start"] = $r2["start"];
        $rr["time"] = $r2["time"];
        $rr["status"] = $r2["status"];
        //$rr["version"] = $r2["version"];
        $sth3 = mysqli_query($con,"SELECT time,status FROM nap_1 WHERE id=".$r["id"]);
        $r3 = mysqli_fetch_assoc($sth3);
        $rr["alltime"]="";
    
        if($r2["status"]==0 && $r3["status"]==0){
            $rr["alltime"]=$r2["time"]+$r3["time"];
        }else{
            $rr["alltime"]="";
        }

        array_map("utf8_encode", $rr);
    if(isset($rr["start"]))$rows[] = $rr;
}
print json_encode($rows);

mysqli_close($con);

?>  