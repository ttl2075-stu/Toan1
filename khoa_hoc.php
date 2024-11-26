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
  <script>
    localStorage.setItem("toc_do",'<?php echo $_SESSION['toc_do']?>')
    localStorage.setItem("giong",'<?php echo $_SESSION['giong']?>')
    localStorage.setItem("toc_do_ho_tro_bang",'<?php echo $_SESSION['toc_do_ho_tro_bang']?>')
    localStorage.setItem("toc_do_ho_tro_tia_so",'<?php echo $_SESSION['toc_do_ho_tro_tia_so']?>')
  </script>

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
  <title>Hệ thống hỗ trợ dạy học môn toán lớp 1 cho học sinh khuyết tật học tập</title>
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
    <!-- <ul>
      <li><a href="template/home.html" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Trang chủ</a></li>
      <li><a href="tinh_phan_thuong.php" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Trang cá nhân</a></li>
      <li><a href="khoa_hoc_v2.php" target="ndung" onclick="toggleSubMenu(this); scrollToPosition(186.4)">Trang khóa học</a></li>
    
    </ul> -->
  </nav>
  <!-- <button id="scrollBtn" onclick="scrollToTop()"><i class="fa-solid fa-expand"></i></button> -->
  <!-- <button id="toggle" class="toggle">
    <i class="fa fa-bars fa-2x"></i>
  </button> -->
  <header>
    <h1>HỌC TOÁN LỚP 1</h1>
    <p>
      Các bài học được biên soạn theo khung chương trình giáo dục phổ thông!
    </p>
    <h3><?php echo $_SESSION['ten']; ?></h3>
    <a id="dang_xuat" href="dang_xuat.php"><button class="cta-btn" id="">Đăng xuất<i class="fa-solid fa-person-walking-arrow-right"></i></button> </a>
  </header>

  <div class="container">
  <div id="content"></div>
    <!-- <iframe src="khoa_hoc_v2.php" name="ndung" id="content" border="0">
       
    </iframe> -->
    <!-- đaadadad -->
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
      var contentDiv = document.getElementById("content");

      fetch('khoa_hoc_v2.php')
          .then(response => response.text())
          .then(data => {
              contentDiv.innerHTML = data;
          })
          .catch(error => {
              console.error('Error fetching the content:', error);
          });
  });
  </script>
  <footer>
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