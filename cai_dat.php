<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    

    $id_user = $_SESSION['id_user'];
    // print_r($id_user);
   $giong_doc_hien_tai =get_toc_do_giong_doc($id_user);
//    print_r($giong_doc_hien_tai);
   $toc_do_hien_tai =get_toc_do_giong_doc($id_user);
//    echo $toc_do_hien_tai;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_cau_hoi.css?v=1">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <title>Cài đặt</title>
    <style>
        form{
            max-height: fit-content;
        }
        input[type="radio"] {
            display: inline;
        }
        body label{
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        #myRange{
            width: 100%;
            min-height: 40px;
        }
        input[type='radio']{
            width: 30px;
            margin-right: 6%;
            height: 30px;
        }
        input[name='btn_cai_dat']{
            margin-top: 20px;
            /* width: 30%; */
            /* text-align: center; */
            padding: 0px;
            margin: auto;
        }
        p{
            min-height: 50px;
            display: flex;
            text-align: left;
            
        }
        body{
            overflow: auto;
        }
        form{
            min-width: 900px;
        }
        .tren{
            width: 100%;
            height: auto;
            display: flex;
            flex-wrap: wrap;
            /* justify-content: space-evenly; */
        }
        h1{
            font-weight: bold;
        }
    </style>
</head>
<body style="min-height: 500px;">
    <!-- <a href="dang_nhap.php"><i class="fa-solid fa-backward"></i>Trở về</a> -->
   
     
    <form style="width: 90%"  action="" method="POST" enctype="multipart/form-data">
        <h1>Cài đặt</h1>
        <label for="">Giọng đọc: </label>
       <div class="tren">
        <p><input type="radio" value="banmai" name="giong" id="">Ban Mai(Nữ miền bắc)</p>
            <p><input type="radio" <?php if($giong_doc_hien_tai['giong']=="leminh"){ echo "checked";} ?> value="leminh" name="giong" id="">Lê Minh (Nam miền bắc)</p>
            <p><input type="radio"  <?php if($giong_doc_hien_tai['giong']=="thuminh"){ echo "checked";} ?> value="thuminh" name="giong" id="">Thu Minh (Nữ miền bắc)</p>
            <p><input type="radio"  <?php if($giong_doc_hien_tai['giong']=="minhquang"){ echo "checked";} ?> value="minhquang" name="giong" id="">Minh Quang (Nam miền nam)</p>
            <p><input type="radio"  <?php if($giong_doc_hien_tai['giong']=="myan"){ echo "checked";} ?> value="myan" name="giong" id="">Mỹ An (Nữ miền trung)</p>
            <p><input type="radio"  <?php if($giong_doc_hien_tai['giong']=="linhsan"){ echo "checked";} ?> value="linhsan" name="giong" id="">Linh san (Nữ miền nam)</p>
            <p><input type="radio"   <?php if($giong_doc_hien_tai['giong']=="giahuy"){ echo "checked";} ?> value="giahuy" name="giong" id="">Gia Huy  (Nam miền trung)</p>
            <p><input type="radio"  <?php if($giong_doc_hien_tai['giong']=="lannhi"){ echo "checked";} ?> value="lannhi" name="giong" id="">Lan Nhi (Nữ miền nam)</p>
            <p><input type="radio" <?php if($giong_doc_hien_tai['giong']=="ngoclam"){ echo "checked";} ?> value="ngoclam" name="giong" id="">Ngọc Lam (Nữ miền trung)</p>
       </div>
        
        <div>
        <label for="">Chỉnh tốc độ đọc</label><br>
        <input name="toc_do" type="range" min="-3" max="3" step="0.5" value="<?php echo $toc_do_hien_tai['toc_do']; ?>" class="slider" id="myRange">
        <p>Tốc độ: <span id="demo"></span></p>
        <!-- chỉnh tốc độ hỗ trợ bảng -->
        <label for="">Chỉnh tốc độ hỗ trợ bảng tính</label><br>
        <input name="toc_do1" type="range" min="1.5" max="5" step="0.5" value="<?php echo $toc_do_hien_tai['toc_do_ho_tro_bang']; ?>" class="slider" id="myRange1">
        <p>Tốc độ: <span id="demo1"></span></p>

        <!-- chỉnh tốc độ hỗ trợ tia số -->
        <label for="">Chỉnh tốc độ hỗ trợ tia số </label><br>
        <input name="toc_do2" type="range" min="1" max="10" step="0.5" value="<?php echo $toc_do_hien_tai['toc_do_ho_tro_tia_so']; ?>" class="slider" id="myRange2">
        <p>Tốc độ: <span id="demo2"></span></p>

        <input type="submit"  name="btn_cai_dat" value="Cập nhật">
        <div style="display: none;" class="alert alert-success">
        <strong>Thành công!</strong>Thay đổi giọng và tốc độ đọc thành công
        </div>
        <div style="display: none;" class="alert alert-danger">
            <strong>Thất bại!</strong>Bạn phải tích vào giọng đọc, không được bỏ trống
        </div>
        <script>
            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            var slider1 = document.getElementById("myRange1");
            var output1 = document.getElementById("demo1");
            var slider2 = document.getElementById("myRange2");
            var output2 = document.getElementById("demo2");
            output.innerHTML = slider.value; // Hiển thị giá trị mặc định
            output1.innerHTML = slider1.value; // Hiển thị giá trị mặc định
            output2.innerHTML = slider2.value; // Hiển thị giá trị mặc định
            // Cập nhật giá trị mỗi khi thanh trượt thay đổi
            slider.oninput = function() {
                output.innerHTML = this.value;
            }
             // Cập nhật giá trị mỗi khi thanh trượt thay đổi
             slider1.oninput = function() {
                output1.innerHTML = this.value;
            }
             // Cập nhật giá trị mỗi khi thanh trượt thay đổi
             slider2.oninput = function() {
                output2.innerHTML = this.value;
            }
           

           
        </script>


    </form>
   
        <?php
            if(isset($_POST['btn_cai_dat'])){
                if(isset($_POST['giong'])){
                    $giong =$_POST['giong'];
                    $toc_do = $_POST['toc_do'];
                    $toc_do_ho_tro_bang = $_POST['toc_do1'];
                    $toc_do_ho_tro_tia_so = $_POST['toc_do2'];
                    // echo $giong." ". $toc_do;
                    // echo $_SESSION['id_user'];
                    $id_user_cai_dat =$_SESSION['id_user'];
                    $sql ="UPDATE `user` SET `giong`='$giong',`toc_do`='$toc_do', `toc_do_ho_tro_bang` = '$toc_do_ho_tro_bang' , `toc_do_ho_tro_tia_so` = '$toc_do_ho_tro_tia_so' WHERE `id_user`='$id_user_cai_dat'";
                    if(mysqli_query($conn,$sql)){
                        // echo 'Cập nhật thành công';
                        ?>
                        <script>document.querySelector('.alert-success').style.display='block'</script>
                        <?php
                    }else{
                       
                        ?>
                         <script>document.querySelector('.alert-danger').style.display='block'</script>
                        <?php
                    }
                    ?>
                    <script>
                        localStorage.setItem("toc_do",'<?php echo $toc_do; ?>')
                        localStorage.setItem("giong",'<?php echo $giong; ?>')
                        localStorage.setItem("toc_do_ho_tro_bang",'<?php echo $toc_do_ho_tro_bang; ?>')
                        localStorage.setItem("toc_do_ho_tro_tia_so",'<?php echo $toc_do_ho_tro_tia_so; ?>')
                        
                    </script>
                    <?php
                }else{
                    ?>
                   <script>document.querySelector('.alert-danger').style.display='block'</script>
                    <?php
                    
                }
                
            }
        ?>
   <?php
    // hàm 
        function get_toc_do_giong_doc($id_user){
            global $conn;
            $sql ="SELECT * FROM `user` WHERE `id_user`='$id_user'";
            $kq = mysqli_query($conn,$sql);
            if(mysqli_num_rows($kq)>0){
                $a = mysqli_fetch_array($kq);
                return $a;
            }else{
                return 0;
            }
        }
        
   ?>
</body>
</html>
