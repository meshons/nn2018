<!DOCTYPE HTML>
<html>

<head>
    <meta lang="hu_HU" />
    <meta charset="utf-8" />
    <title>NN2018 TV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../def.css" />
</head>
<?php

function t($time) {
    $r = "";
    if(intval($time)>=3600){
        $r= $r. (floor(intval($time)/3600)%60).":";
        if(floor(intval($time)/60)%60>9)
            $r= $r.(floor(intval($time)/60)%60).":";
        else
             $r= $r."0".(floor(intval($time)/60)%60).":";
        if(intval($time)%60>9)
            $r= $r.(intval($time)%60);
        else
            $r= $r."0".(intval($time)%60);
    }elseif(intval($time)>=60){
        $r= $r.(floor(intval($time)/60)%60).":";
        if(intval($time)%60>9)
        $r= $r. (intval($time)%60);
        else
        $r= $r. "0".(intval($time)%60);
    }else{
        $r= $r. (intval($time))."";
    }
    return $r;
}
?>

<body>
    <!--<div id="top">Nógrád Nagydíj 1. nap eredmények</div>-->
    <div id="left" class="side">
    <banner>https://github.com/meshons/nn2018 ~ gabor.stork@sch.bme.hu</banner>

        <?php
            require_once("../backend/mysql.php");
            $sth = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
            while($r = mysqli_fetch_assoc($sth)) {
                echo '<category>
                <cnamebox>
                    <cname>'.mb_convert_encoding($r["category"], "UTF-8", "Windows-1252")    .'</cname>
                </cnamebox>
                <result class="top">
                    <pos></pos>
                    <name>Név</name>
                    <club>Egyesület</club>
                    <stime>rajtidő</stime>
                </result>';
                $sth2 = mysqli_query($con,"SELECT lastname,firstname,club,start FROM futok INNER JOIN start_2 ON futok.id = start_2.id WHERE category='".$r["category"]."' ORDER BY start");
                 while($r2 = mysqli_fetch_assoc($sth2)) {
                     echo '<result>
                     <pos></pos>
                     <name>'.mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252")." ".mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252").'</name>
                     <club>'.mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252").'</club>
                     <stime>'.t($r2["start"]).'</stime>
                 </result>';
                 }
                echo '</category>';
            }
        ?>
    </div>
    <div id="right" class="side">
    <banner>https://github.com/meshons/nn2018 ~ gabor.stork@sch.bme.hu</banner>

    <?php
                $sth2 = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
                while($r2 = mysqli_fetch_assoc($sth2)) {
                    $r2["category"] = mb_convert_encoding($r2["category"], "UTF-8", "Windows-1252");
                    echo '<category>
                <cnamebox>
                    <cname>'.  $r2["category"]    .'</cname>
                </cnamebox>
                <result class="top">
                    <pos>Hely</pos>
                    <name>Név</name>
                    <club>Egyesület</club>
                    <stime>Idő</stime>
                    <stimediff>Időkül.</stimediff>
                </result>';
            $i=1;
            $first = 0;
            //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
            $sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category='".$r2["category"]."' ORDER BY status, time");
    while($r = mysqli_fetch_assoc($sth)) {
        if($i==1)$first = $r["time"];
$r["firstname"] = mb_convert_encoding($r["firstname"], "UTF-8", "Windows-1252");
$r["lastname"] = mb_convert_encoding($r["lastname"], "UTF-8", "Windows-1252");
$r["club"] = mb_convert_encoding($r["club"], "UTF-8", "Windows-1252");
echo "<result>
<pos>".($r["status"]==0?$i:"Hiba")."</pos>
<name>".$r["lastname"]." ".$r["firstname"]."</name>
<club>".$r["club"]."</club>
<stime>".t($r["time"])."</stime>
<stimediff>".($i==1 || $r["status"]!=0?"-":"+".t($r["time"]-$first))."</result>
</result>";
        $i = $i+1;

}                echo '</category>';
}
            mysqli_close($con);

        ?>
    </div>
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../scroller.js"></script>
</body>

</html>