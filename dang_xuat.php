<?php
   session_start();
  //  echo "oke";
  //  $id_cau_hoi=$_GET['id_cau_hoi'];
  // / Xóa hết session
  session_destroy();
  header("Location:index.php");
   // $_SESSION['sl_hd']=0;
   // Xóa hết session

   // if(!isset($_SESSION['sl'])){
   //     //session_start();
   //     $_SESSION['sl'][]=0;
   // }
?>