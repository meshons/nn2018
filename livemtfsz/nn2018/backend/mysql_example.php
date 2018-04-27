<?php
$con=mysqli_connect("host","id","pw","db");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  mysqli_set_charset($con,"latin1");

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