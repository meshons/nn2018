<!doctype html>
<html>
<?php
require_once("backend/mysql.php");
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

<head>
    <meta lang="hu_HU" />
    <title>
        Nógrád Nagydíj 2018
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, shrink-to-fit=no">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
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
if(isset($_GET["nap"]) && isset($_GET["kat"])){
?>
<div class="container-fluid">
<h1 style="text-align:center;" class="display-4">Nógrád Nagydíj 2018</h1>
<a style="display:inline-block;" class="mr-2 btn btn-info" href="index.php" role="button">Vissza</a>

<h3 style="display:inline;padding-top:1rem;"><?php echo $_GET["nap"].". nap - ".$_GET["kat"];  ?></h3>

        <table class="table table-striped">
        <?php
            if($_GET["nap"]==1){
                ?>
  <thead>
    <tr>
      <th scope="col">Hely.</th>
      <th scope="col">Név</th>
      <th scope="col">Egyesület</th>
      <th scope="col">Idő</th>
      <th scope="col">Időkül.</th>
      <th scope="col">Részidő.</th>
    </tr>
  </thead>
  <tbody>

                <?php
                //inner join
                $i=1;
                $first = 0;
                //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
                $sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category='".$_GET["kat"]."' ORDER BY status, time");
        while($r = mysqli_fetch_assoc($sth)) {
            if($i==1)$first = $r["time"];
    $r["firstname"] = mb_convert_encoding($r["firstname"], "UTF-8", "Windows-1252");
    $r["lastname"] = mb_convert_encoding($r["lastname"], "UTF-8", "Windows-1252");
    $r["club"] = mb_convert_encoding($r["club"], "UTF-8", "Windows-1252");
    echo "<tr>
    <th scope='row'>".($r["status"]==0?$i:"Hiba").".</th>
    <td>".$r["lastname"]." ".$r["firstname"]."</td>
    <td>".$r["club"]."</td>
    <td>".t($r["time"])."</td>
    <td>".($i==1 || $r["status"]!=0?"-":"+".t($r["time"]-$first))."</td>
    <td><div class='btn btn-primary' style='display:inline;'>Részeredmény</div></td>
  </tr>";
            $i = $i+1;
    
}
?>
 </tbody>
<?php
            }else{

            }
        
        ?>
</table>
</div>
<?php
}}else if($oldal == "rajtlista"){
    echo "x";

}else{
    //eredmény vagy rajtlista
    //melyik nap
    //melyik kategória vagy all
?>
    <div class="container">
        <div class="container">
        <h1 style="text-align:center;" class="display-4">Nógrád Nagydíj 2018</h1>
        </div>
        <div class="row">
            <a style="display:block;" class="col-12 col-md-3 my-1 mx-auto btn btn-primary" href="index.php?oldal=eredmenyek" role="button">Eredmények</a>
            <a style="display:block;;" class="col-12 col-md-3  my-1 mx-auto btn btn-secondary" href="index.php?oldal=rajtlista" role="button">Rajtlista</a>
            <a style="display:block;" class="col-12 col-md-3 my-1 mx-auto btn btn-secondary" href="ertesito.pdf" role="button" download>Értesítő</a>
        </div>
        <div class="row" >
            <div class="col-12 col-md-4">
                <h3>Eredmények:</h3>
                <div class="row">
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">Éjszakai</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-primary" href="#" role="button">1. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">2. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">3. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">Összesített</a>

                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button" download>Váltó</a>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <h3>Megjelenítés:</h3>
            <div class="row">
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-primary" href="#" role="button">Kategóriánkénti</a>
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-secondary" href="#" role="button">Összes</a>
            </div>
            <h3>Eddig beérkezett futóval rendelkező kategóriák:</h3>
            <div class="row">
                <!--<div class="col-4 col-md-3 my-1"><a style="display:block;" class="mx-auto btn btn-primary" href="#" role="button">M16A</a></div>-->

            </div>
            </div>
        </div>
        <div class="row" style="display:none;">
            <div class="col-12 col-md-4" >
                <h3>Rajlista:</h3>
                <div class="row">
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">Éjszakai</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-primary" href="#" role="button">1. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">2. nap</a>
                    <a style="display:block;" class="col-11 my-1 mx-auto btn btn-secondary" href="#" role="button">3. nap</a>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <h3>Megjelenítés:</h3>
            <div class="row">
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-primary" href="#" role="button">Kategóriánkénti</a>
                <a style="display:block;" class="col-5 my-1 mx-auto btn btn-secondary" href="index.php?oldal=rajtlista&nap=0" role="button">Összes</a>
            </div>
            <div class="row" style="display:none">
                    <?php
$sth = mysqli_query($con,"SELECT DISTINCT category FROM futok INNER JOIN night_s on futok.id = night_s.id WHERE 1 ORDER BY category");
while($r = mysqli_fetch_assoc($sth)) {
$r["category"] = mb_convert_encoding($r["category"], "UTF-8", "Windows-1252");
echo "<div class='col-4 col-md-3 my-1'><a style='display:block;' class='mx-auto btn btn-secondary' href='#' role='button'>".$r["category"]."</a></div>";

}
                    ?>
            </div>
            <div class="row"  style="display:none">
                    <?php
$sth = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
while($r = mysqli_fetch_assoc($sth)) {
$r["category"] = mb_convert_encoding($r["category"], "UTF-8", "Windows-1252");
echo "<div class='col-4 col-md-3 my-1'><a style='display:block;' class='mx-auto btn btn-secondary' href='#' role='button'>".$r["category"]."</a></div>";

}
                    ?>
            </div>
            </div>

        </div>
    </div>
<?php
}
?>
</body>

</html>