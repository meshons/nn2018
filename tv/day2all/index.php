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
            $sth = mysqli_query($con,"SELECT cat FROM left_cat_1 WHERE 1 ORDER BY id");
            while($r = mysqli_fetch_assoc($sth)) {
                echo '<category>
                <cnamebox>
                    <cname>'.mb_convert_encoding($r["cat"], "UTF-8", "Windows-1252")    .'</cname>
                </cnamebox>
                <result class="top">
                    <pos></pos>
                    <name>Név</name>
                    <club>Egyesület</club>
                    <atime>Mai idő</atime>
                    <alltime>Összidő</alltime>
                    <atimediff>Időkül</atimediff>
                </result>';
                $i = 1;
                $first = "";
                $sth2 = mysqli_query($con,"SELECT lastname,firstname,club,nap_2.time,nap_1.time+nap_2.time AS alltime FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id INNER JOIN nap_2 ON futok.id=nap_2.id WHERE category='".$r["cat"]."' AND nap_1.status=0 AND nap_2.status=0 ORDER BY alltime");
                 while($r2 = mysqli_fetch_assoc($sth2)) {
                     if($i == 1)$first = $r2["alltime"];
                     echo '<result>
                     <pos>'.$i.'</pos>
                     <name>'.mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252")." ".mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252").'</name>
                     <club>'.mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252").'</club>
                     <atime>'.t($r2["time"]).'</atime>
                     <alltime>'.t($r2["alltime"]).'</alltime>
                    <atimediff>'.($i==1?'':"+".t($r2["alltime"]-$first)).'</atimediff>
                 </result>';
                 $i = $i+1;
                 }
                 $sth3 = mysqli_query($con,"SELECT lastname,firstname,club,nap_2.time FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id INNER JOIN nap_2 ON futok.id=nap_2.id WHERE category='".$r["cat"]."' AND nap_1.status<>0 AND nap_2.status=0 ORDER BY nap_2.time");
                 while($r2 = mysqli_fetch_assoc($sth3)) {
                     echo '<result>
                     <pos>-</pos>
                     <name>'.mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252")." ".mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252").'</name>
                     <club>'.mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252").'</club>
                     <atime>'.t($r2["time"]).'</atime>
                     <alltime></alltime>
                    <atimediff></atimediff>
                 </result>';
                 }
                echo '</category>';
            }
        ?>
    </div>
    <div id="right" class="side">
    <banner>https://github.com/meshons/nn2018 ~ gabor.stork@sch.bme.hu</banner>

    <?php
            require_once("../backend/mysql.php");
            $sth = mysqli_query($con,"SELECT cat FROM right_cat_1 WHERE 1 ORDER BY id");
            while($r = mysqli_fetch_assoc($sth)) {
                echo '<category>
                <cnamebox>
                    <cname>'.mb_convert_encoding($r["cat"], "UTF-8", "Windows-1252")    .'</cname>
                </cnamebox>
                <result class="top">
                    <pos></pos>
                    <name>Név</name>
                    <club>Egyesület</club>
                    <atime>Mai idő</atime>
                    <alltime>Összidő</alltime>
                    <atimediff>Időkül</atimediff>
                </result>';
                $i = 1;
                $first = "";
                $sth2 = mysqli_query($con,"SELECT lastname,firstname,club,nap_2.time,nap_1.time+nap_2.time AS alltime FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id INNER JOIN nap_2 ON futok.id=nap_2.id WHERE category='".$r["cat"]."' AND nap_1.status=0 AND nap_2.status=0 ORDER BY alltime");
                 while($r2 = mysqli_fetch_assoc($sth2)) {
                     if($i == 1)$first = $r2["alltime"];
                     echo '<result>
                     <pos>'.$i.'</pos>
                     <name>'.mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252")." ".mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252").'</name>
                     <club>'.mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252").'</club>
                     <atime>'.t($r2["time"]).'</atime>
                     <alltime>'.t($r2["alltime"]).'</alltime>
                    <atimediff>'.($i==1?'':"+".t($r2["alltime"]-$first)).'</atimediff>
                 </result>';
                 $i = $i+1;
                 }
                 $sth3 = mysqli_query($con,"SELECT lastname,firstname,club,nap_2.time FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id INNER JOIN nap_2 ON futok.id=nap_2.id WHERE category='".$r["cat"]."' AND nap_1.status<>0 AND nap_2.status=0 ORDER BY nap_2.time");
                 while($r2 = mysqli_fetch_assoc($sth3)) {
                     echo '<result>
                     <pos>-</pos>
                     <name>'.mb_convert_encoding($r2["lastname"], "UTF-8", "Windows-1252")." ".mb_convert_encoding($r2["firstname"], "UTF-8", "Windows-1252").'</name>
                     <club>'.mb_convert_encoding($r2["club"], "UTF-8", "Windows-1252").'</club>
                     <atime>'.t($r2["time"]).'</atime>
                     <alltime></alltime>
                    <atimediff></atimediff>
                 </result>';
                 }
                echo '</category>';
            }
        ?>
    </div>
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../scroller.js"></script>
</body>

</html>