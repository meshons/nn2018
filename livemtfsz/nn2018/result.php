<div class="container-fluid">
<h1 style="text-align:center;" class="display-4" onclick="getSplit(9800)">Nógrád Nagydíj 2018</h1>
<a style="display:inline-block;" class="mr-2 btn btn-info" href="index.php?a=0" role="button">Vissza</a>
<?php
if(isset($_GET["nap"]) && isset($_GET["kat"])){
?>


<h3 style="display:inline;padding-top:1rem;"><?php echo ($_GET["nap"]!=0?$_GET["nap"].". nap":"Éjszakai")." - ".$_GET["kat"];  ?></h3>

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
            }elseif($_GET["nap"]==2){
                ?>
                <thead>
    <tr>
      <th scope="col">Hely.</th>
      <th scope="col">Név</th>
      <th scope="col">Egyesület</th>
      <th scope="col">Idő</th>
      <th scope="col">Időkül.</th>
      <th scope="col">Összidő.</th>
      <th scope="col">Részidő.</th>
    </tr>
  </thead>
  <tbody>

                <?php
                //inner join
                $i=1;
                $first = 0;
                //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
                $sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,nap_2.time,nap_2.status,nap_1.status AS allstat,nap_1.time+nap_2.time AS alltime FROM futok INNER JOIN nap_2 ON futok.id = nap_2.id INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category='".$_GET["kat"]."' ORDER BY nap_2.status, nap_2.time");
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
    <td>".($r["allstat"]==0?t($r["alltime"]):"nincs")."</td>
    <td><div class='btn btn-primary' style='display:inline;'>Részeredmény</div></td>
  </tr>";
            $i = $i+1;
    
}
?>
 </tbody>
            <?php
            }elseif($_GET["nap"]==3){
                ?>
                <thead>
    <tr>
      <th scope="col">Hely.</th>
      <th scope="col">Név</th>
      <th scope="col">Egyesület</th>
      <th scope="col">Idő</th>
      <th scope="col">Időkül.</th>
      <th scope="col">Összidő.</th>
      <th scope="col">Részidő.</th>
    </tr>
  </thead>
  <tbody>

                <?php
                //inner join
                $i=1;
                $first = 0;
                //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
                $sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,nap_3.time,nap_3.status,nap_1.status AS allstat,nap_2.status AS allstat2,nap_1.time+nap_2.time+nap_3.time AS alltime FROM futok INNER JOIN nap_2 ON futok.id = nap_2.id INNER JOIN nap_3 ON futok.id = nap_3.id INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category='".$_GET["kat"]."' ORDER BY nap_3.status, nap_3.time");
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
    <td>".($r["allstat"]==0?t($r["alltime"]):"nincs")."</td>
    <td><div class='btn btn-primary' style='display:inline;'>Részeredmény</div></td>
  </tr>";
            $i = $i+1;
    
}
?>
 </tbody>
            <?php
            }elseif($_GET["nap"]==0){
              ?>
              <thead>
  <tr>
    <th scope="col">Hely.</th>
    <th scope="col">Név</th>
    <th scope="col">Egyesület</th>
    <th scope="col">Idő</th>
    <th scope="col">Időkül.</th>
    <th scope="col">Összidő.</th>
    <th scope="col">Részidő.</th>
  </tr>
</thead>
<tbody>

              <?php
              //inner join
              $i=1;
                $first = 0; 
                //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
                $sth = mysqli_query($con,"SELECT futok_n.id,lastname,firstname,club,time,status FROM futok_n INNER JOIN night ON futok_n.id = night.id WHERE category='".$_GET["kat"]."' ORDER BY status, time");
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
          }

        ?>

        
</table>
</div>
<?php
}else if(isset($_GET["nap"])){
  if($_GET["nap"] == 0 || $_GET["nap"]==1){
  $table = "nap_1";
  $futok = "futok";
  if($_GET["nap"]==0){$table="night_s";
  $futok = "futok_n";}
  
  //all
  $sth2 = mysqli_query($con,"SELECT DISTINCT category FROM $futok WHERE 1 ORDER BY category");
while($r2 = mysqli_fetch_assoc($sth2)) {
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
    $i=1;
    $first = 0;
    //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
    $sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,time,status FROM $futok INNER JOIN $table ON $futok.id = $table.id WHERE category='".$r2["category"]."' ORDER BY status, time");
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
</table>
  <?php
}
  }else if($_GET["nap"]==2){
    $sth2 = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
    while($r2 = mysqli_fetch_assoc($sth2)) {
    $r2["category"] = mb_convert_encoding($r2["category"], "UTF-8", "Windows-1252");
    ?>
    <h3 style="display:inline;padding-top:1rem;"><?php echo ($_GET["nap"]!=0?$_GET["nap"].". nap":"Éjszakai")." - ".$r2["category"];  ?></h3>
    
    <table class="table table-striped">
    <thead>
    <tr>
      <th scope="col">Hely.</th>
      <th scope="col">Név</th>
      <th scope="col">Egyesület</th>
      <th scope="col">Idő</th>
      <th scope="col">Időkül.</th>
      <th scope="col">Összidő.</th>
      <th scope="col">Részidő.</th>
    </tr>
    </thead>
    <tbody>
      <?php
    $i=1;
    $first = 0;
    //echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
    $sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,nap_2.time,nap_2.status,nap_1.status AS allstat,nap_1.time+nap_2.time AS alltime FROM futok INNER JOIN nap_2 ON futok.id = nap_2.id INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category='".$r2["category"]."' ORDER BY nap_2.status, nap_2.time");
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
<td>".($r["allstat"]==0?t($r["alltime"]):"nincs")."</td>
<td><div class='btn btn-primary' style='display:inline;'>Részeredmény</div></td>
</tr>";
$i = $i+1;
}
      ?>
    </tbody>
    </table>
    <?php
  }}
  else if($_GET["nap"]==3){
    $sth2 = mysqli_query($con,"SELECT DISTINCT category FROM futok WHERE 1 ORDER BY category");
    while($r2 = mysqli_fetch_assoc($sth2)) {
    $r2["category"] = mb_convert_encoding($r2["category"], "UTF-8", "Windows-1252");
    ?>
    <h3 style="display:inline;padding-top:1rem;"><?php echo ($_GET["nap"]!=0?$_GET["nap"].". nap":"Éjszakai")." - ".$r2["category"];  ?></h3>
    
    <table class="table table-striped">
    <thead>
    <tr>
      <th scope="col">Hely.</th>
      <th scope="col">Név</th>
      <th scope="col">Egyesület</th>
      <th scope="col">Idő</th>
      <th scope="col">Időkül.</th>
      <th scope="col">Összidő.</th>
      <th scope="col">Részidő.</th>
    </tr>
    </thead>
    <tbody>
      <?php
$i=1;
$first = 0;
//echo "SELECT futok.id,lastname,firstname,club,time,status FROM futok INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category=\'".$_GET["cat"]."\' ORDER BY status, time";
$sth = mysqli_query($con,"SELECT futok.id,lastname,firstname,club,nap_3.time,nap_3.status,nap_1.status AS allstat,nap_2.status AS allstat2,nap_1.time+nap_2.time+nap_3.time AS alltime FROM futok INNER JOIN nap_2 ON futok.id = nap_2.id INNER JOIN nap_3 ON futok.id = nap_3.id INNER JOIN nap_1 ON futok.id = nap_1.id WHERE category='".$r2["category"]."' ORDER BY nap_3.status, nap_3.time");
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
<td>".($r["allstat"]==0?t($r["alltime"]):"nincs")."</td>
<td><div class='btn btn-primary' style='display:inline;'>Részeredmény</div></td>
</tr>";
$i = $i+1;

}
      ?>
    </tbody>
    </table>
    <?php
  }
  }
}
?>
<script src="nn2018/split.js"></script>