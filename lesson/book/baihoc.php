<?php
  session_start();
  include '../../connectdb.php';
  if(!isset($_SESSION['id_user'])){
      header('Location: index.php');
      die();
  }
 
  $role=$_SESSION['quyen'];
  $id_user = $_SESSION['id_user'];
  $id_khoa_hoc = $_GET['id_khoa_hoc'];
  $id_bai_hoc=$_GET['id_bai_hoc'];
  // $id_user = $_GET['id_user'];
  // $role = $_GET['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
   @import url('https://fonts.googleapis.com/css?family=Lato&display=swap');

:root {
  --modal-duration: 1s;
  --primary-color: #61c0bf;
  --secondary-color: #bbded6;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Lato', sans-serif;
  margin: 0;
  transition: transform 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
  overflow: hidden; /* Add this line to hide overflow */
}

body.show-nav {
  /* Width of nav */
  transform: translateX(25%);
  width: 80%;
}

button,
input[type='submit'] {
  background-color: var(--secondary-color);
  border: 0;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  padding: 8px 12px;
}

button:focus {
  outline: none;
}

.toggle1 {
  background-color: #61c0bf;
  position: fixed;
  top: 20px;
  left: 20px;
  z-index: 5;
}

.cta-btn {
  padding: 12px 30px;
  font-size: 20px;
}

.container1 {
  display: flex;
  padding: 15px;
  margin: 0 auto;
  min-width: 80%;
  width: 100%;
  height: 100vh; 
  overflow: hidden; 
}
.container1::-webkit-scrollbar, #item1::-webkit-scrollbar {
  width: 0;
}
.right{
    display: flex;
    flex-direction: column;
}
#content {
  min-width: 80%;
  width: 100%;
  min-height: 110vh;
  height: 100%;
  margin: 0 auto;
  border: none;
  overflow: hidden;
}




.close-btn {
  background: transparent;
  font-size: 25px;
  position: absolute;
  top: 0;
  right: 0;
}
.fa-solid.fa-circle-check {
  color: green;
}

@keyframes modalopen {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}
nav {
    background-color: #bbded6;
    border-right: 2px inset whitesmoke;
    color: black;
    position: absolute;
    top: 0;
    left: 0;
    width: 25%;
    height: 100%;
    overflow-y: scroll;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
    border-radius: 5px;
}
nav::-webkit-scrollbar, #item1::-webkit-scrollbar {
    width: 0;
}
nav .logo {
    padding: 30px 0;
    text-align: center;
}

nav .logo img {
    height: 75px;
    width: 75px;
    border-radius: 50%;
}

nav ul {
    padding: 0;
    list-style-type: none;
    margin: 0;
    padding-inline-start: 0px;
    
}

nav ul li {
    border-bottom: 2px inset whitesmoke;
    /* padding: 20px; */
    list-style: none;
}

nav ul>li:first-of-type {
    border-top: 2px solid rgba(200, 200, 200, 0.1);
}

nav ul li a {
    color: grey;
    text-decoration: none;
    display: block;
    width: 100%;
    padding: 20px;
    font-weight: bold;
}


nav li ul {
    display: none;
}

a:hover,
.right a:hover {
    background-color: #61c0bf;
    color: white;
    font-weight: bold;
}

a:focus,
.right a:focus {
  box-shadow: inset 5px 0 0 green; 
  margin-left: 10px;
  color:black;
 font-weight: bold;
}

.right a{
    display: inline-block;
    padding: 10px;
    width: 150px;
    font-weight: bold;
    background-color: #bbded6;
    text-decoration: none;
    margin: 10px 0;
    border-radius: 10px;
    color: grey;
    transition: background-color 0.3s;
    box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset;
}

.key{
    margin-bottom: 20px;
    background-color: #f1d3e3;
    color: #333;
    text-align: center;
    cursor: pointer;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, box-shadow 0.3s;
    position: relative;
    z-index: -2;
}

#anhnote{
  width: 170px;
  height: 200px;
  position: absolute;  
  left: -10px;;
  z-index: -1;
}

.textnote{
  width: 145px;
  position: absolute;
  top:30px;
  left: 0px;
  z-index: 2;
  font-size: 20px;
  font-weight: bold;
}
.fa-fa-circle-check{
  font-size: 100px;
}
#bai_hoc{
  width: 100%;
  height: 50px;
  background-color: #ffb6b9;
  text-align: center;
  line-height: 50px;
  color: black;
}
.fa-circle-check{
  color: green;
  font-size: 30px;
  margin-left: 10px;
}

      .selected {
        background-color: lightgreen; /* Màu nền khi ô được chọn */
    }

    
  </style>
  <title>Toán 1</title>
</head>
  
<body class="show-nav">
  <?php
    if($role==2){
      ?> <nav id="navbar1">
        
      <ul>
        <?php
        
        
        // echo "id_bai_hoc: ".$id_bai_hoc;
        // echo "id_user: ".$id_user;
        // $sql= "SELECT * FROM `bai_tap_user` INNER JOIN `cau_hoi` ON `bai_tap_user`.`id_cau_hoi`=`cau_hoi`.`id_cau_hoi` WHERE `bai_tap_user`.`id_user`='$id_user' AND `id_bai_hoc`='$id_bai_hoc'";
        $sql = "SELECT * FROM `bai_hoc` INNER JOIN `cau_hoi` INNER JOIN `bai_tap_user` WHERE `bai_hoc`.`ma_bai_hoc` =`cau_hoi`.`id_bai_hoc` AND `cau_hoi`.`id_cau_hoi` = `bai_tap_user`.`id_cau_hoi` AND `bai_tap_user`.`id_user`='$id_user' AND `bai_tap_user`.`id_khoa_hoc`='$id_khoa_hoc' AND `cau_hoi`.`id_bai_hoc`='$id_bai_hoc';";
        $kq = mysqli_query($conn, $sql); 
        
        // while($row = mysqli_fetch_assoc($kq)){
        //   echo "<li><a href='../demo1/test.html' target='ndung1'>";
        //     echo $row['ten_cau_hoi']."hello";
        //     echo "</a></li>";
        // }
  
        if (mysqli_num_rows($kq) > 0){
          $i=1;
          while($row = mysqli_fetch_assoc($kq)){
            $id_cau_hoi=$row['id_cau_hoi'];
            $id_loai_hien_thi=$row['id_loai_hien_thi'];
            $id_bai_tap_user = $row['id_bai_tap_user'];
            $link_id = "link_" . $id_bai_tap_user;
            if ($row["id_loai_hien_thi"] == 1){
              
              echo "<li><a id='$link_id' href='../../in_cau_hoi_d6k1.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien_2(\"$link_id\")' target='ndung1'>";
              // echo $row['ten_cau_hoi'];
              echo "Bài $i";
              if($row['trang_thai']==1){
                echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
              }
              // echo $row['id_bai_tap_user'];
              echo "</a></li>";
            }
            elseif ($row["id_loai_hien_thi"] == 3){
              //  e thêm onclick
                echo "<li><a id='$link_id' href='../../in_cau_hoi_d6k3.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien(\"$link_id\")' target='ndung1'>";
                // echo $row['ten_cau_hoi'];
                echo "Bài $i";
                if($row['trang_thai']==1){
                  echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
                }
                // echo $row['id_bai_tap_user'];
                echo "</a></li>";
  
            }
            elseif ($row["id_loai_hien_thi"] == 2 || $row['id_loai_hien_thi']==8){
               
              echo "<li><a id='$link_id' href='../../in_cau_hoi.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien_2(\"$link_id\")' target='ndung1'>";
              // echo $row['ten_cau_hoi'];
              echo "Bài $i";
              if($row['trang_thai']==1){
                echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
              }
              // echo $row['id_bai_tap_user'];
              echo "</a></li>";
          }
            elseif ($row["id_loai_hien_thi"] == 4){
                // $in = "in_cau_hoi_d7k1";
                echo "<li><a id='$link_id' href='../../in_cau_hoi_d7k1.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien_2(\"$link_id\")' target='ndung1'>";
                // echo $row['ten_cau_hoi'];
                echo "Bài $i";
                if($row['trang_thai']==1){
                  echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
                }
                // echo $row['id_bai_tap_user'];
                echo "</a></li>";
            } 
            elseif ($row["id_loai_hien_thi"] == 5){
              // $in = "in_cau_hoi_d7k1";
              echo "<li><a id='$link_id' href='../../in_cau_hoi_d1.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien(\"$link_id\")' target='ndung1'>";
              // echo $row['ten_cau_hoi'];
              echo "Bài $i";
              if($row['trang_thai']==1){
                echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
              }
              // echo $row['id_bai_tap_user'];
              echo "</a></li>";
          } 
          elseif ($row["id_loai_hien_thi"] == 7){
            // $in = "in_cau_hoi_d7k1";
            echo "<li><a id='$link_id' href='../../in_cau_hoi_d3.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien(\"$link_id\")' target='ndung1'>";
            // echo $row['ten_cau_hoi'];
            echo "Bài $i";
            if($row['trang_thai']==1){
              echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
            }
            // echo $row['id_bai_tap_user'];
            echo "</a></li>";
            
        } 
        elseif ($row["id_loai_hien_thi"] == 6){
          // $in = "in_cau_hoi_d7k1";
          echo "<li><a id='$link_id' href='../../in_cau_hoi_d4k1.php?id_bai_tap_user=$id_bai_tap_user&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien(\"$link_id\")' target='ndung1'>";
          // echo $row['ten_cau_hoi'];
          echo "Bài $i";
          if($row['trang_thai']==1){
            echo "<i class='fa-solid fa-circle-check fa-xl' style='color: #20ac82;'></i>";
          }
          // echo $row['id_bai_tap_user'];
          echo "</a></li>";
          
      } 
          $i++;
          }
        }else{
          echo "<li>Không có bài tập</li>";
        }
        
        ?>
      </ul>
    </nav>
    <button id="toggle1" class="toggle1">
      <i class="fa-solid fa-bookmark"></i>
    </button>
    <div id="bai_hoc">
    <h2>Bài học: <?php echo get_ten_bai($id_bai_hoc); ?></h2>
    </div>
    <div class="container1">
    <iframe src="" name="ndung1" id="content" border="0"></iframe>
    <div class="right">
    <a href="ontaphk1.php?id_bai_hoc=<?php echo $id_bai_hoc; ?>">Tài liệu tham khảo</a>
        <div class="key">
          <img src="../../assets/image/note.png" id="anhnote" alt="">
          
          <p class="textnote">
            <u>Từ khóa:</u> <br><br>
            <br/>
            <?php
              // echo "id_khoa_hoc: ".$id_khoa_hoc;
              $sql = "SELECT * FROM `tu_khoa` WHERE `khoa_hoc`='$id_khoa_hoc' and `id_bai_hoc`='$id_bai_hoc'";
              $kq = mysqli_query($conn,$sql);
              if(mysqli_num_rows($kq)>0){
                $row = mysqli_fetch_array($kq);
                echo $row['ten_tu_khoa'];
              }else{
                $sql = "SELECT * FROM `tu_khoa` WHERE `id_bai_hoc`='$id_bai_hoc'";
                $kq = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($kq);
                echo $row['ten_tu_khoa'];
              }
              // $sql= "SELECT * FROM tu_khoa INNER JOIN bai_hoc ON tu_khoa.`ma_bai_hoc`=`bai_hoc`.`ma_bai_hoc` WHERE bai_hoc.`ma_bai_hoc`='$id_bai_hoc' ORDER BY tu_khoa.ma_tu_khoa DESC LIMIT 1";
              // // $sql= "SELECT * FROM `tu_khoa` INNER JOIN `bai_hoc` ON `tu_khoa`.`ma_bai_hoc`=`bai_hoc`.`ma_bai_hoc` WHERE `bai_hoc`.`ma_bai_hoc`=1";
              // $kq = mysqli_query($conn, $sql); 
              // if (mysqli_num_rows($kq) > 0){
              //   while($row = mysqli_fetch_assoc($kq)){
                  
              //       echo $row['ten_tu_khoa'];
                    
              //   }
              // }else{
              //   echo "Không có từ khóa";
              // }
            
            ?>
<!-- <b>Warning</b>:  Undefined array key "folder" in <b>Z:\xampp_v3\htdocs\NCKH_2024\tong_hop_v3\menu\lesson\book\baihoc.php</b> on line <b>303</b><br /> -->
          </p>
        </div>
    </div>
  </div>
 
      <?php
    }
  ?>
 

  

  <script>
  //e thêm hàm 

  <?php
    function get_ten_bai($ma_bai_hoc){
      global $conn;
      $sql ="SELECT * FROM `bai_hoc` WHERE `ma_bai_hoc`='$ma_bai_hoc'";
      $result=mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['ten_bai_hoc'];
      }
      return 0;
    }
  
  ?>
function luubien(id){
  localStorage.setItem('mucdo', 0);
  var links = document.getElementsByTagName('a');
    for (var i = 0; i < links.length; i++) {
        links[i].classList.remove('selected');
    }
    document.getElementById(id).classList.add('selected');
}

function luubien_2(id){
  var links = document.getElementsByTagName('a');
    for (var i = 0; i < links.length; i++) {
        links[i].classList.remove('selected');
    }
    document.getElementById(id).classList.add('selected');
  localStorage.setItem('mucdo_2', 0);
}
  const toggle = document.getElementById('toggle1');
  const close = document.getElementById('close');
  const open = document.getElementById('open');
  const navbar1 = document.getElementById('navbar1');

  // function closeNavbar1(e) {
  //   if (
  //     document.body.classList.contains('show-nav') &&
  //     e.target !== toggle &&
  //     !toggle.contains(e.target) &&
  //     e.target !== navbar1 &&
  //     !navbar1.contains(e.target) && localStorage.getItem('Baitap') === "a"
  //   ) {
  //     document.body.classList.toggle('show-nav');
  //     document.body.removeEventListener('click', closeNavbar1);
  //   } else if (!document.body.classList.contains('show-nav')) {
  //     document.body.removeEventListener('click', closeNavbar1);
  //   }
  // }

  // function scrollToPosition(position) {
  //   window.scrollTo({
  //     top: position,
  //     behavior: 'smooth' // Cuộn mượt
  //   });
  // }

  // Toggle nav
  toggle.addEventListener('click', () => {
    const isNavOpen = document.body.classList.toggle('show-nav');
    if (isNavOpen) {
      localStorage.setItem('Baitap', 'a');
    } else {
      localStorage.setItem('Baitap', 'b');
    }
  });

  // });
    </script>
  </body>

</html>
