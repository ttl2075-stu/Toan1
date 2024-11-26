<?php
  session_start();
  // print_r($_SESSION);
  include 'connectdb.php';
  if(!isset($_SESSION['id_user'])){
      header('Location: index.php');
      die();
  }
 
  $role=$_SESSION['quyen'];
  $id_user = $_SESSION['id_user'];
  $id_khoa_hoc = $_GET['id_khoa_hoc'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/menu.css" />
  <link rel="stylesheet" href="assets/css/scrollbar.css" />
  <link rel="shortcut icon" type="image/png" href="anh/logo.png"/>
  <style>
     #dang_xuat{
      color: white;
      text-decoration: none;
      font-weight: bold;
      color:black;
     }
     #dang_xuat:hover{
      background-color: none;
     }

     footer{
      /* margin-top: 20px; */
      /* top: 10%; 
      position: relative; */
      text-align: center;
      color: white;
      font-size: 50px;
      font-weight: bold;
     }
     #scrollBtn {
      display: none;
      position: fixed;
      bottom: 25%;
      right: 20px;
      z-index: 99;
      cursor: pointer;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 15px;
      font-size: 16px;
    }


    footer {
      /* background-color: #333; */
      color: #fff;
      padding: 10px 0;
      /* text-align: center; */
      background-color: var(--primary-color);
      height: 20vh;
      min-width: 80%;
      width: 100%;
      /* position: fixed ;
      bottom: 0 ; */
    }


.footer-content p {
  font-size: 40px;
  margin-bottom: 5px;
}

.content {
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-wrap: wrap;
}

.address,
.contact-info,
.social-icons {
  font-size: 20px;
  margin-bottom: 10px;
}

.address span,
.contact-info span {
  display: block;
}


.footer-content i{
  color: #fff;
  font-size: 24px;
  margin: 0 10px;
  transition: color 0.3s ease;
  /* box-shadow: 0px 2px 8px 0px aqua; */
  background-color: none;
}
.footer-content .social-icons .icon i:hover{
  color: aquamarine;
  cursor: pointer;
}

/* .cta-btn{
  background-color: #fff;
  color: black;
  font-weight: bold;
} */


.cta-btn i {
  transition: all 0.3s ease;
  font-size: 25px;
}

.cta-btn:hover i {
  transform: rotate(360deg);
}

.cta-btn:hover i:before {
  content: "\f1d9"; 
}
  </style>
  <title>Trang chủ</title>
  <script>
var baseURL = "../../book";
var currentPath = "";

function updateFolderValue(link, event) {
    event.preventDefault();

    // Lấy giá trị của thẻ <a>
    var folderValue = (link.innerText || link.textContent).trim();

    var tempPath = currentPath;

    var parentFolders = [];
    var currentElement = link;
    while (currentElement) {
        if (currentElement.tagName === "LI") {
            var folderName = currentElement.querySelector("a").innerText.trim();
            parentFolders.unshift(folderName);
        }
        currentElement = currentElement.parentElement.closest("li");
    }

    currentPath = parentFolders.join("/");

    var newHref = baseURL + "/" + currentPath;
    link.setAttribute("href", newHref);
    
   
    console.log("Đường dẫn đầy đủ:", newHref);
    
    // Khôi phục giá trị của currentPath nếu không thay đổi thành công
    if (!link.nextElementSibling || link.nextElementSibling.tagName !== "UL") {
        currentPath = tempPath;
    }
    if (!link.nextElementSibling || link.nextElementSibling.tagName !== "UL") {
      var iframe = document.getElementById('content');
      localStorage.setItem('dangbaihoc', newHref);
      iframe.src = ("lesson/book/baihoc.php?folder=" + newHref); 
    }
}
</script>
</head>
  
<body>
 
  <nav id="navbar">
    <div class="logo">
      <img src="assets/image/logo.jpg" alt="user" />
    </div>
    <ul>
      <li><a href="trang_chu.php?id_khoa_hoc=<?php echo$id_khoa_hoc ?>">Trang chủ</a></li>
      <li><a href="tinh_phan_thuong.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>"  onclick="toggleSubMenu(this); scrollToPosition(186.4)">Trang cá nhân</a></li>
      <!-- <li><a href="test_js.php?id_khoa_hoc=<?php //echo $id_khoa_hoc?>" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Giao bài tập</a></li> -->
      <li><a href="khoa_hoc.php" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Trở về</a></li>
      <?php
        if($role==1){
          ?>
          <li><a href="nhap_cau_hoi.php<?php echo"?id_khoa_hoc=$id_khoa_hoc"; ?>" target="ndung" onclick="toggleSubMenu(this)">Nhập câu hỏi</a>
          <li><a href="them_tu_khoa.php" target="ndung" onclick="toggleSubMenu(this)">Nhập từ khóa</a>
          
          <li><a href="chinh_phan_thuong.php<?php echo"?id_khoa_hoc=$id_khoa_hoc"; ?>" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Thay đổi phần thưởng</a></li>
          <li><a href="nhap_de_thi.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>" target="ndung" onclick="toggleSubMenu(this)">Giao bài tập</a>
          <?php
            // echo ($role ==1) ? "nhap_de_thi.php" : " baihoc.php";
        }
        if($role==1 || $role==3){
          ?><li><a href="danh_sach_giao_bt.php<?php echo"?id_khoa_hoc=$id_khoa_hoc"; ?>" target="ndung" onclick="toggleSubMenu(this)">Danh sách học sinh được giao bài tập</a>
         <?php
        }
      ?>
      
      <?php
        if($role==2){?>
          <li><a onclick="toggleSubMenu(this)">Bài học</a> 
          <ul class="submenu0">
            <li><a href="#" onclick="toggleSubMenu(this); updateFolderValue(this, event)" >1. Số và phép tính </a>
              <ul class="submenu1">
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this);updateFolderValue(this, event)">1.1. Số tự nhiên </a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.1.1. Các số từ 0 - 10</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=1&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Các số 0, 1, 2, 3, 4, 5</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=2&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Các số 6, 7, 8, 9, 10</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=3&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Nhiều hơn, ít hơn, bằng nhau</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=4&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >So sánh số</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=5&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Mấy và mấy</a></li>
                        <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=6&role=" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.1.2. Các số từ 100</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Số có hai chữ số</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=14&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >So sánh số có hai chữ số</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=15&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Bảng các số từ 1 đến 100</a></li>
                        <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=10&role=" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.2. Các phép tính số tự nhiên</a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.2.1 Phép cộng, phép trừ trong phạm vi 10</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=8&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Phép cộng trong phạm vi 10</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=9&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Phép trừ trong phạm vi 10</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=10&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Bảng cộng, bảng trừ trong phạm vi 10</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.2.2 Phép cộng, phép trừ không nhớ trong phạm vi
                        100</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=19&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Phép cộng số có hai chữ số với số có một chữ số</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=20&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Phép cộng số có hai chữ số với số có hai chữ số</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=21&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Phép trừ số có hai chữ số cho số có một chữ số</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=22&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Phép trừ số có hai chữ số cho số có hai chữ số</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">2. Hình học và đo lường</a>
              <ul class="submenu1">
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.1. Hình học</a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.1.1. Làm quen với một số hình phẳng</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=6&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Hình vuông, hình tròn, hình tam giác, hình chữ nhật</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=7&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Thực hành lắp ghép, xếp hình</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.1.2. Làm quen với một số hình học khối</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=11&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Khối lập phương, khối hộp chữ nhật</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=12&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Vị trí, định hướng trong không gian</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.2. Đo lường</a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.2.1. Độ dài và đo độ dài</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=16&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Dài hơn, ngắn hơn </a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=17&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Đơn vị đo độ dài</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=18&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Thực hành ước lượng và đo độ dài</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.2.2. Thời gian, giờ và lịch</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=24&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Xem đúng giờ trên đồng hồ</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=24&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Các ngày trong tuần</a></li>
                        <li><a href="lesson/book/baihoc.php?id_bai_hoc=25&id_khoa_hoc=<?php echo $id_khoa_hoc?>" target="ndung" >Thực hành xem lịch và giờ</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <!-- <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">3. Ôn tập học kì I</a> -->
              <!-- <ul class="submenu1"> -->
                <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung"  id="lesson">3.1. Ôn tập các số trong phạm vi 10</a></li> -->
                <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung" >3.2. Ôn tập phép cộng, phép trừ trong phạm vi 10</a></li> -->
                <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung" >3.3. Ôn tập hình học</a></li> -->
                <!-- <li><a href="#" target="ndung" >3.4. Ôn tập chung</a></li> -->
              <!-- </ul> -->
            <!-- </li> -->
            <!-- <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">4. Ôn tập cuối năm</a> -->
              <!-- <ul class="submenu1"> -->
                <!-- <li><a href="#" target="ndung" >4.1. Ôn tập các số và phép tính trong phạm vi 10</a></li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.2. Ôn tập các số và phép tính trong phạm vi 100</a></li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.3. Ôn tập hình học và đo lường</a></li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.4. Ôn tập chung</a></li>
              </ul> -->
            <!-- </li> -->
          </ul>
        </li><?php
        }
      ?>
      <?php
        if($role==1||$role==3){
          ?>   <li><a onclick="toggleSubMenu(this)">Tài liệu tham khảo</a> 
          <ul class="submenu0">
            <li><a href="#" onclick="toggleSubMenu(this); updateFolderValue(this, event)" >1. Số và phép tính </a>
              <ul class="submenu1">
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this);updateFolderValue(this, event)">1.1. Số tự nhiên </a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.1.1. Các số từ 0 - 10</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=1" target="ndung" >Các số 0, 1, 2, 3, 4, 5</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=2" target="ndung" >Các số 6, 7, 8, 9, 10</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=3" target="ndung" >Nhiều hơn, ít hơn, bằng nhau</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=4" target="ndung" >So sánh số</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=5" target="ndung" >Mấy và mấy</a></li>
                        <!-- <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=6&role=" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.1.2. Các số từ 100</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=13" target="ndung" >Số có hai chữ số</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=14" target="ndung" >So sánh số có hai chữ số</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=15" target="ndung" >Bảng các số từ 1 đến 100</a></li>
                        <!-- <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=10&role=" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.2. Các phép tính số tự nhiên</a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.2.1 Phép cộng, phép trừ trong phạm vi 10</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=8" target="ndung" >Phép cộng trong phạm vi 10</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=9" target="ndung" >Phép trừ trong phạm vi 10</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=10" target="ndung" >Bảng cộng, bảng trừ trong phạm vi 10</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">1.2.2 Phép cộng, phép trừ không nhớ trong phạm vi
                        100</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=19" target="ndung" >Phép cộng số có hai chữ số với số có một chữ số</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=20" target="ndung" >Phép cộng số có hai chữ số với số có hai chữ số</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=21" target="ndung" >Phép trừ số có hai chữ số cho số có một chữ số</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=22" target="ndung" >Phép trừ số có hai chữ số cho số có hai chữ số</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">2. Hình học và đo lường</a>
              <ul class="submenu1">
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.1. Hình học</a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.1.1. Làm quen với một số hình phẳng</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=6" target="ndung" >Hình vuông, hình tròn, hình tam giác, hình chữ nhật</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=7" target="ndung" >Thực hành lắp ghép, xếp hình</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.1.2. Làm quen với một số hình học khối</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=11" target="ndung" >Khối lập phương, khối hộp chữ nhật</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=12" target="ndung" >Vị trí, định hướng trong không gian</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.2. Đo lường</a>
                  <ul class="submenu2">
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.2.1. Độ dài và đo độ dài</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=16" target="ndung" >Dài hơn, ngắn hơn </a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=17" target="ndung" >Đơn vị đo độ dài</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=18" target="ndung" >Thực hành ước lượng và đo độ dài</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                    <li><a href="#" target="ndung" onclick="toggleSubMenu(this); updateFolderValue(this, event)">2.2.2. Thời gian, giờ và lịch</a>
                      <ul class="submenu3">
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=24" target="ndung" >Xem đúng giờ trên đồng hồ</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=24" target="ndung" >Các ngày trong tuần</a></li>
                        <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=25" target="ndung" >Thực hành xem lịch và giờ</a></li>
                        <!-- <li><a href="#" target="ndung" >Luyện tập chung</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <!-- <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">3. Ôn tập học kì I</a> -->
              <!-- <ul class="submenu1"> -->
                <!-- <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=13&role=" target="ndung"  id="lesson">3.1. Ôn tập các số trong phạm vi 10</a></li> -->
                <!-- <li><a href="lesson/book/ontaphk1.php?id_bai_hoc=13&role=" target="ndung" >3.2. Ôn tập phép cộng, phép trừ trong phạm vi 10</a></li> -->
                <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung" >3.3. Ôn tập hình học</a></li> -->
                <!-- <li><a href="#" target="ndung" >3.4. Ôn tập chung</a></li> -->
              <!-- </ul> -->
            <!-- </li> -->
            <!-- <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">4. Ôn tập cuối năm</a> -->
              <!-- <ul class="submenu1"> -->
                <!-- <li><a href="#" target="ndung" >4.1. Ôn tập các số và phép tính trong phạm vi 10</a></li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.2. Ôn tập các số và phép tính trong phạm vi 100</a></li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.3. Ôn tập hình học và đo lường</a></li>
                <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.4. Ôn tập chung</a></li>
              </ul> -->
            <!-- </li> -->
          </ul>
        </li><?php
        }
      ?>

   

      <!-- <li><a href="lesson/luyentap/index.html" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Luyện tập</a></li>
      <li><a target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Liên hệ</a></li> --> 
      
      <!-- tài liệu tham khảo cho giáo viên -->
      
          <!-- <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">3. Ôn tập học kì I</a> -->
            <!-- <ul class="submenu1"> -->
              <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung"  id="lesson">3.1. Ôn tập các số trong phạm vi 10</a></li> -->
              <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung" >3.2. Ôn tập phép cộng, phép trừ trong phạm vi 10</a></li> -->
              <!-- <li><a href="lesson/book/baihoc.php?id_bai_hoc=13&role=" target="ndung" >3.3. Ôn tập hình học</a></li> -->
              <!-- <li><a href="#" target="ndung" >3.4. Ôn tập chung</a></li> -->
            <!-- </ul> -->
          <!-- </li> -->
          <!-- <li><a onclick="toggleSubMenu(this); updateFolderValue(this, event)">4. Ôn tập cuối năm</a> -->
            <!-- <ul class="submenu1"> -->
              <!-- <li><a href="#" target="ndung" >4.1. Ôn tập các số và phép tính trong phạm vi 10</a></li>
              <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.2. Ôn tập các số và phép tính trong phạm vi 100</a></li>
              <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.3. Ôn tập hình học và đo lường</a></li>
              <li><a href="#" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4); updateFolderValue(this, event)">4.4. Ôn tập chung</a></li>
            </ul> -->
          <!-- </li> -->
        <!-- </ul> -->
      
    </ul>
  </nav>
  <!-- <button id="scrollBtn" onclick="scrollToTop()"><i class="fa-solid fa-expand"></i></button> -->
  <button id="toggle" class="toggle">
    <i class="fa fa-bars fa-2x"></i>
  </button>
  <header>
    <h1>HỌC TOÁN LỚP 1</h1>
    <p>
      Các bài học được biên soạn theo khung chương trình giáo dục phổ thông!
    </p>
    <h3><?php echo $_SESSION['ten']; ?></h3>
    <a id="dang_xuat" href="dang_xuat.php"><button class="cta-btn" id="">Đăng xuất<i class="fa-solid fa-person-walking-arrow-right"></i></button> </a>
  </header>

  <div class="container">
    <!-- <iframe src="" name="ndung" id="content" border="0">

    </iframe>
     -->
<h2>Đồng hành học toán lớp 1 dành cho học sinh cần hỗ trợ</h2>
<p>
  Nêu ý nghĩa của website.
</p>
<p>
  Website là hệ thống học tập hỗ trợ cho phụ huynh và học sinh học tập tại nhà......
</p>

<h2>Chương trình đào tạo</h2>

<p>
  Khung chương trình toán học lớp 1 của BGD qui định về..
</p>

<h2>Lơi ích</h2>
<ul style="list-style: none;">
  <li >Hỗ trợ cha mẹ trong việc hướng dẫn học sinh học bài tại nhà</li>
  <li>Các bài hướng dẫn dễ hiểu</li>
  <li>Bài tập đa dạng</li>
  <li>Phù hợp với từng cá nhân</li>
</ul>
<h2>Cấu trúc bài học</h2>
<p>
  <ul  style="list-style: none;">
  <li>Học liệu đa dạng</li>
  <li>Bài tập tham chiếu nhiều nguồn</li>
  <li>Xây dựng theo cá nhân người học</li>
  <li>....</li>
</ul>
</p>

  </div>
  <footer >
  <div class="footer-content">
    <p>Trường Đại học Sư phạm Hà Nội</p>
    <div class="content">
      <div class="address">
        <span><i class="fa-solid fa-location-dot"></i>136 Xuân Thuỷ - Cầu Giấy - Hà Nội</span>
      </div>
      <div class="contact-info">
        <span><i class="fa-regular fa-envelope"></i>p.hcdn@hnue.edu.vn</span>
        <span><i class="fa-solid fa-phone-volume"></i> 024-37547823 - Fax: 024-37547971</span>
      </div>
    </div>
  </div>
</footer>
  <!-- Modal -->
  <div class="modal-container" id="modal">
    <div class="modal">
      <button class="close-btn" id="close">
        <i class="fa fa-times"></i>
      </button>
      <!-- <div class="modal-header">
         <h3>Sign Up</h3> -->
      <!-- </div> --> 
      <div class="modal-content">
        <p>Register with us to get offers, support and more</p>
        <form class="modal-form">
          <div>
            <label for="name">Name</label>
            <input type="text" id="name" placeholder="Enter Name" class="form-input" />
          </div>
          <div>
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter Email" class="form-input" />
          </div>
          <div>
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter Password" class="form-input" />
          </div>
          <div>
            <label for="password2">Confirm Password</label>
            <input type="password" id="password2" placeholder="Confirm Password" class="form-input" />
          </div>
          <input type="submit" value="Submit" class="submit-btn" />
        </form>
      </div>
    </div>
  </div>

  <script src="assets/js/script.js"></script>
  <script>
    // Function to scroll to top
    function scrollToTop() {
      window.scrollTo({
        top: 187,
        behavior: 'smooth'
      });
    }

    // Show scroll button when scrolling down
    window.onscroll = function() {
      scrollFunction();
    };

    function scrollFunction() {
      if (document.body.scrollTop != 187 || document.documentElement.scrollTop != 187) {
        document.getElementById("scrollBtn").style.display = "block";
      } else {
        document.getElementById("scrollBtn").style.display = "none";
      }
    }
  </script>
</body>

</html>