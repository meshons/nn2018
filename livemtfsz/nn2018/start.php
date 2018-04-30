<div class="container-fluid">
<h1 style="text-align:center;" class="display-4">Nógrád Nagydíj 2018</h1>
<a style="display:inline-block;" class="mr-2 btn btn-info" href="index.php?a=1&b=<?php echo $_GET["nap"]; ?>" role="button">Vissza</a>
<?php
$table = $_GET["nap"];
if(isset($_GET["kat"])){
    ?>
    <h3 style="display:inline;padding-top:1rem;"><?php echo ($_GET["nap"]!=0?$_GET["nap"].". nap":"Éjszakai")." - ".$_GET["kat"];  ?></h3>

    <table class="table table-striped">
<thead>
<tr>
  <th scope="col"></th>
  <th scope="col">Név</th>
  <th scope="col">Egyesület</th>
  <th scope="col">Rajtidő</th>

</tr>
</thead>
<tbody>

            <?php
            //inner join
            $table = "start_1";
    $futok = "futok";
    if($_GET["nap"]==0){$table="night_s";
    $futok = "futok_n";}
    if($_GET["nap"]==2)$table="start_2";
    if($_GET["nap"]==3)$table="start_3";


            //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
        $sth2 = mysqli_query($con,"SELECT $futok.id,lastname,firstname,club,start FROM $futok INNER JOIN $table ON $futok.id = $table.id WHERE category='".$_GET["kat"]."' ORDER BY start");
    while($r = mysqli_fetch_assoc($sth2)) {
$r["firstname"] = mb_convert_encoding($r["firstname"], "UTF-8", "Windows-1252");
$r["lastname"] = mb_convert_encoding($r["lastname"], "UTF-8", "Windows-1252");
$r["club"] = mb_convert_encoding($r["club"], "UTF-8", "Windows-1252");
echo "<tr>
<th scope='row'></th>
<td>".$r["lastname"]." ".$r["firstname"]."</td>
<td>".$r["club"]."</td>
<td>".t($r["start"])."</td>
</tr>";

    }
?>
</tbody></table>
<?php

        

}else{

    $table = "start_1";
    $futok = "futok";
    if($_GET["nap"]==0){$table="night_s";
    $futok = "futok_n";}
    //all
    if($_GET["nap"]==2)$table="start_2";
    if($_GET["nap"]==3)$table="start_3";

    $sth = mysqli_query($con,"SELECT DISTINCT category FROM $futok WHERE 1 ORDER BY category");
while($r2 = mysqli_fetch_assoc($sth)) {
$r2["category"] = mb_convert_encoding($r2["category"], "UTF-8", "Windows-1252");
?>
<h3 style="display:inline;padding-top:1rem;"><?php echo ($_GET["nap"]!=0?$_GET["nap"].". nap":"Éjszakai")." - ".$r2["category"];  ?></h3>

<table class="table table-striped">
<thead>
<tr>
<th scope="col"></th>
<th scope="col">Név</th>
<th scope="col">Egyesület</th>
<th scope="col">Rajtidő</th>

</tr>
</thead>
<tbody>

        <?php
        //inner join
        //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
    $sth2 = mysqli_query($con,"SELECT $futok.id,lastname,firstname,club,start FROM $futok INNER JOIN $table ON $futok.id = $table.id WHERE category='".$r2["category"]."' ORDER BY start");
while($r = mysqli_fetch_assoc($sth2)) {
$r["firstname"] = mb_convert_encoding($r["firstname"], "UTF-8", "Windows-1252");
$r["lastname"] = mb_convert_encoding($r["lastname"], "UTF-8", "Windows-1252");
$r["club"] = mb_convert_encoding($r["club"], "UTF-8", "Windows-1252");
echo "<tr>
<th scope='row'></th>
<td>".$r["lastname"]." ".$r["firstname"]."</td>
<td>".$r["club"]."</td>
<td>".t($r["start"])."</td>
</tr>";

}
?>
</tbody></table>
<?php
    }
}
?>
