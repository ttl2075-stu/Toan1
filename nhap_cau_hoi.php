<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    // $id_cau_hoi = $_GET['id_cau_hoi'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/nhap_cau_hoi.css?v=1">
    <link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
    <title>Nhập câu hỏi chung</title>
</head>

<body>
    <!-- <a href="dang_nhap.php"><i class="fa-solid fa-backward"></i>Trở về</a> -->
    <?php 
    // $role= $_GET['role'];
    // $id_user= $_GET['id_user'];
    // $id_bai_hoc=1;
    // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
    // echo "hdad";
       
        // Danh sách hàm
        function get_loai_hien_thi($conn,$ten_bang){
            $a=[];
            $sql = "SELECT * FROM $ten_bang";
            $kq=mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($kq)) {
                $a[] = $row;
                
            }
            return $a;
        }
    // phân quyền giáo viên
    if($role==1)
        ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1 class="title">NHẬP CÂU HỎI</h1>
        <label for="">Câu hỏi: </label>
        <input value="Đặt tính rồi tính?" required type="text" name="cau_hoi" id="cau_hoi">
        <?php 
            echo "<input type='hidden' name='role' value='$role'>";
            echo "<input type='hidden' name='id_user' value='$id_user'>"
        ?>

        <input type="hidden" name="id_user">
        <div>
            <label for="">Chọn loại câu hỏi</label>
            <select name="loai_ht" id="abc">
                <?php
            
            
             $sql ="SELECT * FROM `loai_hien_thi`";
             $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['id_loai_hien_thi']."'>".$row['ten_loai_hien_thi'] ."</option>";
                }
                echo "</select>";
             }  
             
            ?>
                <label for="">Chọn bài học</label>
                <select name="bai_hoc" id="">
                    <?php
            
            
             $sql ="SELECT * FROM `bai_hoc`";
             $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['ma_bai_hoc']."'>".$row['ten_bai_hoc'] ."</option>";
                }
                echo "</select>";
             }  
             
            ?>
        </div>

        <input class="btn-submit" type="submit" name="btn" value="Nhập câu hỏi"><br>

        <?php //echo "<a href='nhap_de_thi.php'><i class='fa-solid fa-file-import'></i>Giao bài tập</a>"?>



    </form>
    <?php
        if(isset($_POST['btn'])){
            $cau_hoi = $_POST['cau_hoi'];
            // echo "$cau_hoi";
            // $so1 = $_POST['so_thu_nhat'];
            // $so2 = $_POST['so_thu_hai'];
            // $bieu_thuc = $_POST['bieu_thuc'];
            $id_bai_hoc=$_POST['bai_hoc'];
            // $da = $_POST['da'];
           
            // Kiểm tra kết nối
            // if (!$conn) {
            //     die("Kết nối thất bại: " . mysqli_connect_error());
            // }
            $loai_ht=$_POST['loai_ht'];
            echo "loại: "."$loai_ht";
            echo "id_bài học"."$id_bai_hoc";

            // Bổ sung câu insert trường id_user và thời gian tạo createdby: ndthien - tối 31/3/2024 
            // $sql = "INSERT INTO `cau_hoi` (`id_cau_hoi`, `ten_cau_hoi`, `anh`, `id_bai_hoc`,`url_dung_do`,`id_loai_hien_thi`,`url_doi_tuong`) VALUES (null, '$cau_hoi', Null, '$id_bai_hoc',null,'$loai_ht',null)";
            $sql= "INSERT INTO `cau_hoi`(`id_cau_hoi`, `ten_cau_hoi`, `anh`, `id_bai_hoc`, `url_dung_do`, `id_loai_hien_thi`, `url_doi_tuong`, `id_user`, `thoi_gian`) VALUES (null,'$cau_hoi',null,'$id_bai_hoc',null,'$loai_ht',null, $id_user, NOW())";
            // Thực hiện thêm record
            if (mysqli_query($conn, $sql)) {
                echo "Thêm record thành công";
                $last_id = mysqli_insert_id($conn);
                if($loai_ht==1){
                    header("Location:nhap_d6k1.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
                }elseif($loai_ht==2){
                    header("Location:nhap_sl_d6_k2.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
                }
                elseif($loai_ht==3){
                    header("Location:nhap_cau_hoi_d6k3.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
                }
                elseif($loai_ht==4){
                    header("Location:nhap_cau_hoi_d7k1.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
                }
                // mới bổ sung
                elseif($loai_ht==5){
                    header("Location:nhap_cau_hoi_d1.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
             
                }
                elseif($loai_ht==6){
                    header("Location:nhap_cau_hoi_d4k1.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
             
                }
                elseif($loai_ht==7){
                    header("Location:nhap_cau_hoi_d3.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
             
                }
                elseif($loai_ht==8){
                    header("Location:nhap_sl_d6_k2.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$last_id&id_loai_cau_hoi=$loai_ht");
            
                }
                
            } else {
                echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
            }
            
           
        }
    ?>

    <!-- <div class="danhsach">
        <button onclick="showQuestions()"><i class="fa-solid fa-pen-to-square"></i>Danh sách các câu hỏi đã thêm</button>
        <button onclick="showExercises()"><i class="fa-solid fa-book"></i>Danh sách bài tập</button>
    </div> -->

    <script>
    function showQuestions() {
        var x = document.getElementById("questions-section");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function showExercises() {
        var x = document.getElementById("exercises-section");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    document.getElementById('abc').addEventListener('change', function() {
        var cauHoiInput = document.getElementById('cau_hoi');
        var selectedOption = this.options[this.selectedIndex].value;
        if (selectedOption == 1) {
            cauHoiInput.value = "Đặt tính rồi tính ?";
        } else if (selectedOption == 2) {
            cauHoiInput.value = "Nối?";
        } else if (selectedOption == 3) {
            cauHoiInput.value = "Đếm và chọn số con vật/ đồ vật tương ứng?";
        } else if (selectedOption == 4) {
            cauHoiInput.value = "Tính?";
        } else if (selectedOption == 5) {
            cauHoiInput.value = "Đếm và chọn số con vật/ đồ vật tương ứng?";
        } else if (selectedOption == 7) {
            cauHoiInput.value = "Đếm và chọn số con vật/ đồ vật tương ứng?";
        } else if (selectedOption == 8) {
            cauHoiInput.value = "Đếm và chọn số con vật/ đồ vật tương ứng?";
        }
        // console.log(selectedOption);

    });
    </script>

</body>

</html>