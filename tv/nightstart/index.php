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
        <?php
            require_once("../backend/mysql.php");
            $sth = mysqli_query($con,"SELECT cat FROM night_cat_1 WHERE 1 ORDER BY id");
            while($r = mysqli_fetch_assoc($sth)) {
                echo '<category>
                <cnamebox>
                    <cname>'.mb_convert_encoding($r["cat"], "UTF-8", "Windows-1252")    .'</cname>
                </cnamebox>
                <result class="top">
                    <pos></pos>
                    <name>Név</name>
                    <club>Egyesület</club>
                    <stime>rajtidő</stime>
                </result>';
                $sth2 = mysqli_query($con,"SELECT lastname,firstname,club,start FROM futok_n INNER JOIN night_s ON futok_n.id = night_s.id WHERE category='".$r["cat"]."' ORDER BY start");
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
    <?php
            require_once("../backend/mysql.php");
            $sth = mysqli_query($con,"SELECT cat FROM night_cat_2 WHERE 1 ORDER BY id");
            while($r = mysqli_fetch_assoc($sth)) {
                echo '<category>
                <cnamebox>
                    <cname>'.mb_convert_encoding($r["cat"], "UTF-8", "Windows-1252")    .'</cname>
                </cnamebox>
                <result class="top">
                    <pos></pos>
                    <name>Név</name>
                    <club>Egyesület</club>
                    <stime>rajtidő</stime>
                </result>';
                $sth2 = mysqli_query($con,"SELECT lastname,firstname,club,start FROM futok_n INNER JOIN night_s ON futok_n.id = night_s.id WHERE category='".$r["cat"]."' ORDER BY start");
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
            mysqli_close($con);

        ?>
    </div>
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../scroller.js"></script>
</body>

</html>