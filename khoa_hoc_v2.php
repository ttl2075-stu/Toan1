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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Khóa học</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
  <style>
    .btn-primary{
      background-color: #1a6bb2;
      border-color: #1a6bb2;
    }
  </style>
</head>
<body>
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Toán 1 2024</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo get_ten($id_user); ?>           </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> -->
	<main style="min-height: 100vh; width: 100%;">
		<div class="" style="text-align: center;">
			<h2>Khóa học</h2>
		</div>
		<div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
		<?php 
				
                if($role==0){
                    $listKhoaHoc = getAllKhoaHoc(0);
					foreach ($listKhoaHoc as $khoaHoc){ 
				// 	?>
				 	<!-- begin khóa học -->
				 	<div class="col">
					    <div class="card" >
                        <img src="./anh/<?php echo $khoaHoc['url_anh']; ?>" class="card-img-top" alt="Course Image" style="width:100%">
                          
				 	      <div class="card-body">
				 	        <h5 class="card-title"><?php echo $khoaHoc['ten_khoa_hoc']; ?></h5>
				 	        <a target="_parent" href="mo_dau.php?id_khoa_hoc=<?php echo $khoaHoc['id_khoa_hoc']; ?>" class="btn btn-primary">Truy cập</a>
				 	      </div>
				 	    </div>
				 	</div>
				 	<?php 
				    }
                }else{
                    $listKhoaHoc = getAllKhoaHoc($id_user);
                    if(count($listKhoaHoc)==0){?>
                        <h5 class="card-title" style="text-align: center;">Bạn chưa được thêm vào khóa học</h5><?php
                    }
					else{
                        foreach ($listKhoaHoc as $khoaHoc){ 
                        // 
                       

                       
                         	?>
                          
                                <!-- begin khóa học -->
                                <div class="col">
                                <div class="card">
                                      <img  src="./anh/<?php echo $khoaHoc['url_anh']; ?>" class="card-img-top" alt="Course Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $khoaHoc['ten_khoa_hoc']; ?></h5>
                                        <a target="_parent" href="mo_dau.php?id_khoa_hoc=<?php echo $khoaHoc['id_khoa_hoc']; ?>" class="btn btn-primary">Truy cập</a>
                                    </div>
                                    </div>
                                </div>
                                <?php  
                        }
                    }
                }
			 ?>

    <!-- <script>
    function exitFrame() {
    // Lấy đối tượng iframe bằng ID
    var frame = document.getElementById("myFrame");
    
    // Kiểm tra xem frame có tồn tại không
    if (frame) {
        // Gán 'src' thành một giá trị trống
        frame.src = "about:blank";
        
        // Ẩn frame
        frame.style.display = "none";
    }
    }
</script> -->
			

		</div>
	</main>
	
</body>
    <?php
        function getAllKhoaHoc($id_user)
        {
            GLOBAL $conn;
            $listKhoaHoc = [];
            if($id_user==0){
                $sql = "SELECT * FROM `khoa_hoc`";
            }
            else{
                $sql = "SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `khoa_hoc` WHERE `thanh_vien_khoa_hoc`.`id_khoa_hoc` = `khoa_hoc`.`id_khoa_hoc` AND `thanh_vien_khoa_hoc`.`id_user`='$id_user'";
           
            }
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)) {
                    $listKhoaHoc[] = $row;
                }
            }
            return $listKhoaHoc;
        }
        function get_ten($id_user){
            GLOBAL $conn;
           $ten="";
            
            $sql = "SELECT * FROM `user` WHERE `id_user`='$id_user'";
            
          
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)) {
                    $ten = $row['ten'];
                }
            }
            return $ten;
        }
    ?>
	
</html>