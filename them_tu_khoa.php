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
    <link rel="stylesheet" href="src/css/nhap_cau_hoi.css">
    <link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
    <title>Thêm từ khóa</title>
</head>

<body>
    <!-- <a href="dang_nhap.php"><i class="fa-solid fa-backward"></i>Trở về</a> -->
    <?php 
    // $role= $_GET['role'];
    // $id_user= $_GET['id_user'];
    // $id_bai_hoc=1;
    // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
    // echo "hdad";
        function get_loai_hien_thi($conn,$ten_bang){
            $a=[];
            $sql = "SELECT * FROM $ten_bang";
            $kq=mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($kq)) {
                $a[] = $row;
                
            }
            return $a;
        }

    if($role==1)
        ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1 class="title">Nhập từ khóa</h1>
        <label for="">Từ khóa </label>
        <input required type="text" name="tu_khoa" id="">
        <?php 
            echo "<input type='hidden' name='role' value='$role'>";
            echo "<input type='hidden' name='id_user' value='$id_user'>"
        ?>

        <input type="hidden" name="id_user">
        <div>
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

        <input class="btn-submit" type="submit" name="btn" value="Thêm từ khóa"><br>

    </form>
    <?php
        if(isset($_POST['btn'])){
            $tu_khoa = $_POST['tu_khoa'];
            // echo "$cau_hoi";
            // $so1 = $_POST['so_thu_nhat'];
            // $so2 = $_POST['so_thu_hai'];
            // $bieu_thuc = $_POST['bieu_thuc'];
            $id_bai_hoc=$_POST['bai_hoc'];

            if (!$conn) {
                die("Kết nối thất bại: " . mysqli_connect_error());
            }
            // echo "id_khoa_hoc: ".$id_khoa_hoc;
            $sql = "SELECT * FROM `tu_khoa` WHERE `khoa_hoc`='$id_khoa_hoc' and `id_bai_hoc`='$id_bai_hoc'";
            $kq = mysqli_query($conn,$sql);
            if(mysqli_num_rows($kq)>0){
                $sql ="UPDATE `tu_khoa` SET `ten_tu_khoa`='$tu_khoa' WHERE `id_bai_hoc`='$id_bai_hoc' AND `khoa_hoc` = '$id_khoa_hoc'";
            }else{
                $sql ="INSERT INTO `tu_khoa`(`id_tu_khoa`, `ten_tu_khoa`, `id_bai_hoc`, `khoa_hoc`) VALUES (null,'$tu_khoa','$id_bai_hoc','$id_khoa_hoc')";
            }
            mysqli_query($conn,$sql);
            ?><script>
    alert("Thay đổi từ khóa thành công");
    </script><?php
        }
    ?>

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
    </script>
</body>

</html>