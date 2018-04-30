<!doctype html>
<html>
<?php
require_once("nn2018/backend/mysql.php");
?>

<head>
    <meta lang="hu_HU" />
    <meta charset="utf-8"/>
    <title>
        Nógrád Nagydíj 2018
    </title>
    <link rel="stylesheet" href="nn2018/bootstrap.min.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, shrink-to-fit=no">
    <script src="nn2018/jquery-3.3.1.min.js"></script>
    <script src="nn2018/bootstrap.bundle.min.js"></script>
    <meta property="og:url"                content="http://live.mtfsz.hu" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="Nógrád Nagydíj 2018 Élő eredmények" />
<meta property="og:description"        content="Kövesd élőben a Nógrád Nagydíj fejleményeit" />
<meta property="og:image"              content="http://live.mtfsz.hu/nn2018/facebook.jpg" />
</head>
<body>
<?php
$oldal = "fooldal";
if(isset($_GET["oldal"]))
$oldal = $_GET["oldal"];
if($oldal == 'eredmeny'){
require("nn2018/result.php");
}else if($oldal == "rajtlista"){
    require("nn2018/start.php");

}else{

    $a =0;
    $b =2;
    if(isset($_GET["a"]))
    $a = $_GET["a"];
    if(isset($_GET["b"]))
    $b = $_GET["b"];
?>
    <div class="container">
        <div class="container">
        <h1 style="text-align:center;" class="display-4">Nógrád Nagydíj 2018</h1>
        </div>
        <div class="row">
            <a style="display:block;" class="col-12 col-md-3 my-1 mx-auto btn <?php echo ($a==0?"btn-primary":"btn-secondary"); ?>" href="?a=0" role="button">Eredmények</a>
            <a style="display:block;;" class="col-12 col-md-3  my-1 mx-auto btn  <?php echo ($a==1?"btn-primary":"btn-secondary"); ?>" href="?a=1" role="button">Rajtlista</a>
            <a style="display:block;" class="col-12 col-md-3 my-1 mx-auto btn btn-secondary" href="nn2018/ertesito.pdf" role="button" download>Értesítő</a>
        </div>
<?php
if($a==0){
?>
        <div class="row">
            <div class="col-12 col-md-4">
                <h3>Eredmények:</h3>
                <div class="row">
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==0)?"primary":"secondary"; ?>" href="index.php?a=0&b=0" role="button">Éjszakai</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==1)?"primary":"secondary"; ?>" href="index.php?a=0&b=1" role="button">1. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==2)?"primary":"secondary"; ?>" href="index.php?a=0&b=2" role="button">2. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==3)?"primary":"secondary"; ?>" href="index.php?a=0&b=3" role="button">3. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==4)?"primary":"secondary"; ?>" href="index.php?a=0&b=4" role="button">Összetett</a>

                </div>
            </div>
            <div class="col-12 col-md-8">
                <h3>Megjelenítés:</h3>
            <div class="row">
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-primary" href="#" role="button">Kategóriánkénti</a>
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-secondary" href="index.php?oldal=eredmeny&nap=<?php echo $b; ?>" role="button">Összes</a>
            </div>
            <?php if($b==0){ ?>
            <div class="row">
<?php

$sth = mysqli_query($con,"SELECT DISTINCT category FROM futok_n WHERE 1 ORDER BY category");
while($r = mysqli_fetch_assoc($sth)) {
$r["category"] = mb_convert_encoding($r["category"], "UTF-8", "Windows-1252");
echo "<div class='col-4 col-md-3 my-1'><a style='display:block;' class='mx-auto btn btn-secondary' href='index.php?oldal=eredmeny&nap=0&kat=".$r["category"]."' role='button'>".$r["category"]."</a></div>";

}
                    ?>

            </div>
            <?php
            }elseif($b==1 || $b==2 || $b==3 || $b==4){
            ?>
            <div class="row">
<?php

$sth = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
while($r = mysqli_fetch_assoc($sth)) {
$r["category"] = mb_convert_encoding($r["category"], "UTF-8", "Windows-1252");
echo "<div class='col-4 col-md-3 my-1'><a style='display:block;' class='mx-auto btn btn-secondary' href='index.php?oldal=eredmeny&nap=$b&kat=".$r["category"]."' role='button'>".$r["category"]."</a></div>";

}
                    ?>

            </div>
            <?php
            }
            ?>
            </div>
        </div>
        <?php
       }else if($a==1){
        ?>
        <div class="row">
            <div class="col-12 col-md-4" >
                <h3>Rajlista:</h3>
                <div class="row">
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==0)?"primary":"secondary"; ?>" href="index.php?a=1&b=0" role="button">Éjszakai</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==1)?"primary":"secondary"; ?>" href="index.php?a=1&b=1" role="button">1. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==2)?"primary":"secondary"; ?>" href="index.php?a=1&b=2" role="button">2. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-<?php echo ($b==3)?"primary":"secondary"; ?>" href="index.php?a=1&b=3" role="button">3. nap</a>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <h3>Megjelenítés:</h3>
            <div class="row">
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-primary" href="#" role="button">Kategóriánkénti</a>
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-secondary" href="index.php?oldal=rajtlista&nap=<?php echo $b; ?>" role="button">Összes</a>
            </div>
            <?php 
                if($b == 0){
            ?>
            <div class="row">
                    <?php
$sth = mysqli_query($con,"SELECT DISTINCT category FROM futok_n WHERE 1 ORDER BY category");
while($r = mysqli_fetch_assoc($sth)) {
$r["category"] = mb_convert_encoding($r["category"], "UTF-8", "Windows-1252");
echo "<div class='col-4 col-md-3 my-1'><a style='display:block;' class='mx-auto btn btn-secondary' href='index.php?oldal=rajtlista&nap=0&kat=".$r["category"]."' role='button'>".$r["category"]."</a></div>";

}
                    ?>
            </div>
            <?php
                }else if($b==1 || $b==2 || $b==3){
            ?>
            <div class="row">
                    <?php
$sth = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
while($r = mysqli_fetch_assoc($sth)) {
$r["category"] = mb_convert_encoding($r["category"], "UTF-8", "Windows-1252");
echo "<div class='col-4 col-md-3 my-1'><a style='display:block;' class='mx-auto btn btn-secondary'  href='index.php?oldal=rajtlista&nap=$b&kat=".$r["category"]."' role='button'>".$r["category"]."</a></div>";

}
                    ?>
            </div>
            
            <?php
        }}
            ?>
    </div>
<?php
}
?>
<h6 style="display:block; text-align:center;opacity:0.5; " class="mx-auto">
<a href="https://github.com/meshons/nn2018">github.com/meshons/nn2018</a> ~ <a href="mailto:gabor.stork@sch.bme.hu?subject=NN2018">gabor.stork@sch.bme.hu</a>
</h6>
</body>

</html>