<!DOCTYPE html>
<html lang="en">
<?php
// bước 1
    $DB_HOST = 'localhost'; // tên host
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'quan_ly_bai_hoc'; // tên database
    // myspl_connect // kết nối php với mysql
    $conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
    if($conn){
        mysqli_query($conn,"SET NAMES 'utf8'");
    }

?>
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
  --primary-color: #30336b;
  --secondary-color: #be2edd;
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
  background-color: rgba(0, 0, 0, 0.3);
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
    background-color: #f1d3e3;
    border-right: 2px solid rgba(200, 200, 200, 0.1);
    color: #333;
    position: absolute;
    top: 0;
    left: 0;
    width: 25%;
    height: 100%;
    overflow-y: scroll;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
    border-radius: 20px;
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
    border-bottom: 2px solid rgba(200, 200, 200, 0.1);
    /* padding: 20px; */
    list-style: none;
}

nav ul>li:first-of-type {
    border-top: 2px solid rgba(200, 200, 200, 0.1);
}

nav ul li a {
    color: #333;
    text-decoration: none;
    display: block;
    width: 100%;
    padding: 20px;
}


nav li ul {
    display: none;
}

a:hover,
.right a:hover {
    background-color: #a8abe7;
}

.right a{
    display: inline-block;
    padding: 10px;
    width: 150px;
    font-weight: bold;
    background-color: #706df2;
    text-decoration: none;
    margin: 10px 0;
    border-radius: 10px;
    color: white;
    transition: background-color 0.3s;
}
.right a{
    background-color: #8495e7;
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
  </style>
  <title>Toán 1</title>
</head>
  
<body>
  <nav id="navbar1">
    <ul>

    <?php 
    function tach($text){
      $vi_tri = strrpos($text, '/');

      return substr($text, $vi_tri + 1);
    }

    // function choose_book($e){
    //           $last_paragraph_start = strrpos($e, ".") + 1;
    //           $last_paragraph = substr($e, $last_paragraph_start);
    //           return trim($last_paragraph);
    // }

    function delete_cach($text){
        return str_replace(" ", "", $text);
    }
    // $sql = "SELECT * FROM `bai_hoc`
    // JOIN `danh_sach_bai_tap` ON bai_hoc.ma_bai_hoc = danh_sach_bai_tap.ma_bai_hoc";
    $sql="SELECT * FROM `bai_tap_user` INNER JOIN `cau_hoi` ON `bai_tap_user`.`id_cau_hoi`=`cau_hoi`.`id_cau_hoi` WHERE `bai_tap_user`.`id_user`=1 AND `id_bai_hoc`=1";
    // $folder = tach($_GET['folder']);

    $a = mysqli_query($conn, $sql); 
  
    while($row = mysqli_fetch_assoc($a)){
     
      if(delete_cach($row['ten_bai_hoc']) == delete_cach($folder)){
        echo "<li><a href='../demo1/test.html' target='ndung1'>";
        echo $row['ten_cau_hoi']."hello";
        echo "</a></li>";
      }
    }
    
    ?>    
    </ul>
  </nav>
  <button id="toggle1" class="toggle1">
    <i class="fa-solid fa-bookmark"></i>
  </button>

  <div class="container1">
    <iframe src="" name="ndung1" id="content" border="0"></iframe>
    <div class="right">
        <a href="ontaphk1.php?folder=<?php echo $_GET['folder']?>">Tài liệu tham khảo</a>
        <div class="key">
          <img src="../../assets/image/note.png" id="anhnote" alt="">
          
          <p class="textnote">
            <u>Từ khóa:</u> <br><br>
            <?php 
            $sql = "SELECT * FROM `bai_hoc`
            JOIN `tu_khoa` ON bai_hoc.ma_bai_hoc = tu_khoa.ma_bai_hoc";
            
            $folder = tach($_GET['folder']);
        
            $a = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($a)){
                if(delete_cach($row['ten_bai_hoc']) == delete_cach(($folder))){
                  echo $row['ten_tu_khoa'];
                  break;
              }}
            ?>
          </p>
        </div>
    </div>
  </div>
 

  <script>
const toggle = document.getElementById('toggle1');
const close = document.getElementById('close');
const open = document.getElementById('open');
const navbar1 = document.getElementById('navbar1');

function closeNavbar1(e) {
  if (
    document.body.classList.contains('show-nav') &&
    e.target !== toggle &&
    !toggle.contains(e.target) &&
    e.target !== navbar1 &&
    !navbar1.contains(e.target) && localStorage.getItem('Baitap') === "a"
  ) {
    document.body.classList.toggle('show-nav');
    document.body.removeEventListener('click', closeNavbar1);
  } else if (!document.body.classList.contains('show-nav')) {
    document.body.removeEventListener('click', closeNavbar1);
  }
}

function scrollToPosition(position) {
  window.scrollTo({
    top: position,
    behavior: 'smooth' // Cuộn mượt
  });
}

// Toggle nav
toggle.addEventListener('click', () => {
  const isNavOpen = document.body.classList.toggle('show-nav');
  if (isNavOpen) {
    localStorage.setItem('Baitap', 'a');
  } else {
    localStorage.setItem('Baitap', 'b');
  }
});

if (localStorage.getItem('Baitap') === 'a') {
  document.body.classList.add('show-nav');
} else {
  document.body.classList.remove('show-nav');
}

window.addEventListener('storage', function() {
  var baihoc = localStorage.getItem('Baihoc');
  if (baihoc === 'b') {
    window.location.href="baihoc.php?folder=" + localStorage.getItem("dangbaihoc");
  }else{
    window.location.href="baihoc.php?folder=" + localStorage.getItem("dangbaihoc");
  }
});
  </script>
<?php 
 mysqli_close($conn);
?>
</body>

</html>