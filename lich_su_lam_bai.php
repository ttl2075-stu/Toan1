<?php 
    session_start();

    include 'connectdb.php';
    if (!isset($_SESSION['id_user'])) {
        header('Location: index.php');
        die();
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css_v2/lich_su_lam_bai.css">

    <title>Lịch sử làm bài</title>
    <style>
        *{
            font-family: 'Roboto', sans-serif;
        }
        .show {
            /* position: absolute;
            top: 10%;
            left: 5%; */
            
            position: relative;
            background-color: #fff;
            padding: 50px 55px;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 2px 8px 0px #1E97F3;
            /* text-align: center; */
            width: 60%;
            min-height: 300px;
            /* max-height: 500px; */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            margin: auto;
            font-size: 30px;
            margin-top: 40px;

            
        }
        .show>span{
            position: absolute;
            top: 0px;
            left: 0px;
            font-size: large;
            margin: 10px;
            font-weight: bold;
            font-size: 33px;
            
        }
        .phep_tinh{
            width: 8%;
            min-height: 100px;
            /* background-color: lightblue; */
            margin: 0px auto;
            /* font-size: 33px; */
        }
        .phep_tinh_hang1, .phep_tinh_hang3, .phep_tinh_hang5{
            text-align: right;
        }
        .phep_tinh_hang4>hr{
            height: 3px;
            background-color: black;
        }
        .phep_tinh_hang5 {
        
            font-weight: bold;
            color: lightsalmon;
            
        }
        .show>.tb_dung{
            position: absolute;
            width: 10%;
            height: 10%;
            right: 0px;
            top: 0px;
            border-radius: 30px;
            text-align: center;
            background-color: #198754;
            color: white;
            padding-top: 1%;
            box-sizing: border-box;
            
        }
        .show>.tb_sai{
            position: absolute;
            width: 10%;
            height: 10%;
            right: 0px;
            top: 0px;
            border-radius: 30px;
            text-align: center;
            background-color: #ffc107;
            color: white;
            padding-top: 1%;
            box-sizing: border-box;
        }
        .back{
            display: block;
            width: 6%;
            height: 6vh;
            border-radius: 20px;
            text-align: center;
            padding-top: 1%;
            box-sizing: border-box;
            background-color: #dc3545;
            color:white;
            color:white;
            text-decoration: none;
        }
        .show_d7_k1{
            /* position: absolute;
            top: 10%;
            left: 5%; */
            
            position: relative;
            background-color: #fff;
            padding: 50px 55px;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 2px 8px 0px #1E97F3;
            /* text-align: center; */
            width: 60%;
            min-height: 100px;
            /* max-height: 500px; */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            margin: auto;
            font-size: 30px;
            margin-top: 40px;

            
        }
        .show_d7_k1 .khoi{
            width: 40%;
            height: 100px;
            /* background-color:#198754; */
            margin: 0px auto;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            font-size: 40px;
        }
        .show_d7_k1>.tb_dung{
            position: absolute;
            width: 10%;
            height: 10%;
            right: 0px;
            top: 0px;
            border-radius: 30px;
            text-align: center;
            background-color: #198754;
            color: white;
            padding-top: 1%;
            box-sizing: border-box;
            
        }
        .show_d7_k1>.tb_sai{
            position: absolute;
            width: 10%;
            height: 10%;
            right: 0px;
            top: 0px;
            border-radius: 30px;
            text-align: center;
            background-color: #ffc107;
            color: white;
            padding-top: 1%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <?php
        $id_bai_tap_user = $_GET['id_bai_tap_user'];
        $id_bai_hoc = $_GET['id_bai_hoc'];
        $id_khoa_hoc= $_GET['id_khoa_hoc'];
        $id_user1 = $_GET['id_user'];
        // echo "id_bai_tap_user: ".$id_bai_tap_user;
        $thong_tin = lay_loai_hien_thi($id_bai_tap_user);
        
        // tên câu hỏi
        $ten_cau_hoi = $thong_tin['ten_cau_hoi'];
        $id_cau_hoi = $thong_tin['id_cau_hoi'];
        // echo "id_câu_hỏi: ".$id_cau_hoi;
        $loai_hien_thi = $thong_tin['id_loai_hien_thi'];
        // echo $loai_hien_thi;
        $id_user = $thong_tin['id_user'];
        // end 

        ?><a class="back" href="<?php echo "danh_sach_giao_bt_chi_tiet_2.php?id_bai_tap_user=$id_bai_tap_user&id_bai_hoc=$id_bai_hoc&id_khoa_hoc=$id_khoa_hoc&id_user=$id_user1"; ?>" id="btn_tro_ve">Trở về</a><?php 
        
        // dạng d6k1 
        if($loai_hien_thi ==1){

            // begin đếm số lần làm bài của người dùng
           
            $sql = "SELECT  COUNT(*) AS so_luong_ban_ghi  FROM `dap_an_nguoi_dung_d6k1` WHERE `id_bai_tap_user`=$id_bai_tap_user";
            $kq = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($kq);
            // print_r($row['so_luong_ban_ghi']);
            ?><h2>Số lần làm: <?php echo $row['so_luong_ban_ghi']; ?></h2><?php
            // end đếm số lần làm bài của người dùng
            $so_thu_nhat = thu_tu_cau_hoi($id_cau_hoi,1,"dap_an_d6k1");
            $phep_tinh = thu_tu_cau_hoi($id_cau_hoi,2,"dap_an_d6k1");
            $so_thu_hai = thu_tu_cau_hoi($id_cau_hoi,3,"dap_an_d6k1");
            $dap_an = thu_tu_cau_hoi($id_cau_hoi,5,"dap_an_d6k1");
           
            // echo $so_thu_hai['ten_dap_an'];
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k1` WHERE `id_bai_tap_user`=$id_bai_tap_user";
            $kq = mysqli_query($conn,$sql);
            $stt=1;
            while($row = mysqli_fetch_array($kq)){
                // print_r($row['luu_vet']); echo "<br>";
                $luu_vet = json_decode($row['luu_vet'], true);
                
                // print_r($luu_vet);
                
                ?>
            
                <!-- begin in ra  -->
            


                <div class="show">
                    <span>Lần: <?php echo  $stt;?> </span>
                    <h2>Tên đề bài: <?php echo $ten_cau_hoi; ?></h2>
                    <?php
                        if($dap_an['ten_dap_an']==$row['dap_an']){

                            ?><div class="tb_dung">Đúng </div><?php
                        }else{
                            ?><div class="tb_sai">Sai</div><?php
                        } 
                    ?>
                  
                    
                    <div class="phep_tinh">
                            <div class="phep_tinh_hang1"><?php echo $so_thu_nhat['ten_dap_an']; ?></div>
                            <div class="phep_tinh_hang2"><?php echo $phep_tinh['ten_dap_an']; ?></div>
                            <div class="phep_tinh_hang3"><?php echo $so_thu_hai['ten_dap_an']; ?></div>
                            <div class="phep_tinh_hang4"><hr></div>
                            <div class="phep_tinh_hang5"><?php echo $row['dap_an']; ?></div>
                    </div>
                    <!-- <div class="thoi_gian_lam_bai">
                        <p>Thời gian bắt đầu làm: </p>
                        <p>Thời gian nộp bài: </p>
                    </div> -->
                    <div class="danh_sach_sd_huong_dan">
                        <h4>Danh sách các gợi ý dùng trong bài</h4>
                        <ol>
                            <?php echo lay_ten_ho_tro($luu_vet); ?>
                         </ol>
                    </div>
                </div>
                <!-- end in ra -->
            <?php
                $stt++;
            }
            
        }
        // end dạng d6k1
        elseif($loai_hien_thi ==4){
            $so_thu_nhat = thu_tu_cau_hoi($id_cau_hoi,1,"dap_an_d7k1");
            $phep_tinh = thu_tu_cau_hoi($id_cau_hoi,2,"dap_an_d7k1");
            $so_thu_hai = thu_tu_cau_hoi($id_cau_hoi,3,"dap_an_d7k1");
            $dap_an = thu_tu_cau_hoi($id_cau_hoi,5,"dap_an_d7k1");
           
           
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d7k1` WHERE `id_bai_tap_user`=$id_bai_tap_user";
            $kq = mysqli_query($conn,$sql);
            $stt=1;
            while($row = mysqli_fetch_array($kq)){
               
                $luu_vet = json_decode($row['luu_vet'], true);
                ?>
                <div class="show_d7_k1">
                    <span>Lần: <?php echo  $stt;?> </span>
                    <h3>Câu hỏi: <?php echo $ten_cau_hoi; ?></h3>
                    <div class="khoi">
                        <div class="so1"><?php echo $so_thu_nhat['ten_dap_an']; ?></div>
                        <div class="phep_tinh1"><?php echo $phep_tinh['ten_dap_an']; ?></div>
                        <div class="so2"><?php echo $so_thu_hai['ten_dap_an']; ?></div>
                        <div class="phep_tinh2">=</div>
                        <div class="ket_qua"><?php echo $row['dap_an']; ?></div>
                    </div>
                    <div class="danh_sach_sd_huong_dan">
                        <h4>Danh sách các gợi ý dùng trong bài</h4>
                        <ol>
                            <?php echo lay_ten_ho_tro($luu_vet); ?>
                         </ol>
                    </div>
                    <?php 
                        
                        if($dap_an['ten_dap_an']==$row['dap_an']){

                            ?><div class="tb_dung">Đúng </div><?php
                        }else{
                            ?><div class="tb_sai">Sai</div><?php
                        } 
                    ?>
                    
                    
                </div>
                
                <?php 
                $stt++;

                
            }

            
        }
        elseif($loai_hien_thi ==2){
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k2` WHERE `id_bai_tap_user`=$id_bai_tap_user";
                    $kq = mysqli_query($conn,$sql);
                    $stt=1;
                    while($row = mysqli_fetch_array($kq)){
                        
                        $luu_vet = json_decode($row['luu_vet'], true);
                        // print_r($luu_vet);
                        
                        ?>
                         <div class="show_d7_k1">
                        <div class="danh_sach_sd_huong_dan">
                        <h4>Lần: <?php echo $stt; ?></h4>
                        <h4>Danh sách các gợi ý dùng trong bài</h4>
                        <ol>
                            <?php echo lay_ten_ho_tro($luu_vet); ?>
                         </ol>
                    </div></div>
                    <?php
                    $stt++;
                    }
                    
            ?>

           
             
            
            <?php 
        }
        // toán tình huống
        elseif($loai_hien_thi ==3){
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`=$id_bai_tap_user";
                    $kq = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($kq)>0){
                        $stt=4;
                        while($row = mysqli_fetch_array($kq)){
                            
                            $luu_vet = json_decode($row['luu_vet'], true);
                            // print_r($luu_vet);
                            if($stt %4==0){
                                ?>
                                <div class="show_d7_k1">
                               <div class="danh_sach_sd_huong_dan">
                               <h4>Lần: <?php echo $stt/4; ?></h4>
                               <h4>Danh sách các gợi ý dùng trong bài</h4>
                               <ol>
                                   <?php echo lay_ten_ho_tro($luu_vet); ?>
                                </ol>
                           </div></div>
                           <?php
                            
                            }
                            $stt++; 
                       
                    }
                   
                    }
                    else{
                        ?>  <div class="show_d7_k1">HS chưa làm bài tập</div><?php
                    }
                    
            ?>

           
             
            
            <?php 
        }
        // đếm số lượng
        elseif($loai_hien_thi ==5){
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`=$id_bai_tap_user";
                    $kq = mysqli_query($conn,$sql);
                    $stt=1;
                    while($row = mysqli_fetch_array($kq)){
                        
                        $luu_vet = json_decode($row['luu_vet'], true);
                        // print_r($luu_vet);
                        
                        ?>
                         <div class="show_d7_k1">
                        <div class="danh_sach_sd_huong_dan">
                        <h4>Lần: <?php echo $stt; ?></h4>
                        <h4>Danh sách các gợi ý dùng trong bài</h4>
                        <ol>
                            <?php echo lay_ten_ho_tro($luu_vet); ?>
                         </ol>
                    </div></div>
                    <?php
                    $stt++;
                    }
                    
            ?>

           
             
            
            <?php 
        }
         // điền phép so sánh
         elseif($loai_hien_thi ==6){
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`=$id_bai_tap_user";
                    $kq = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($kq)>0){
                        $stt=3;
                        while($row = mysqli_fetch_array($kq)){
                            
                            $luu_vet = json_decode($row['luu_vet'], true);
                            // print_r($luu_vet);
                            if($stt %3==0){
                                ?>
                                <div class="show_d7_k1">
                               <div class="danh_sach_sd_huong_dan">
                               <h4>Lần: <?php echo $stt/3; ?></h4>
                               <h4>Danh sách các gợi ý dùng trong bài</h4>
                               <ol>
                                   <?php echo lay_ten_ho_tro($luu_vet); ?>
                                </ol>
                           </div></div>
                           <?php
                            
                            }
                            $stt++; 
                       
                    }
                   
                    }
                    else{
                        ?>  <div class="show_d7_k1">HS chưa làm bài tập</div><?php
                    }
                    
            ?>

           
             
            
            <?php 
        }
          // đếm số lượng
          elseif($loai_hien_thi ==7){
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`=$id_bai_tap_user";
                    $kq = mysqli_query($conn,$sql);
                    $stt=1;
                    while($row = mysqli_fetch_array($kq)){
                        
                        $luu_vet = json_decode($row['luu_vet'], true);
                        // print_r($luu_vet);
                        
                        ?>
                         <div class="show_d7_k1">
                        <div class="danh_sach_sd_huong_dan">
                        <h4>Lần: <?php echo $stt; ?></h4>
                        <h4>Danh sách các gợi ý dùng trong bài</h4>
                        <ol>
                            <?php echo lay_ten_ho_tro($luu_vet); ?>
                         </ol>
                    </div></div>
                    <?php
                    $stt++;
                    }
                    
            ?>

           
             
            
            <?php 
        }
        elseif($loai_hien_thi ==8){
            $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k2` WHERE `id_bai_tap_user`=$id_bai_tap_user";
                    $kq = mysqli_query($conn,$sql);
                    $stt=1;
                    while($row = mysqli_fetch_array($kq)){
                        
                        $luu_vet = json_decode($row['luu_vet'], true);
                        // print_r($luu_vet);
                        
                        ?>
                         <div class="show_d7_k1">
                        <div class="danh_sach_sd_huong_dan">
                        <h4>Lần: <?php echo $stt; ?></h4>
                        <h4>Danh sách các gợi ý dùng trong bài</h4>
                        <ol>
                            <?php echo lay_ten_ho_tro($luu_vet); ?>
                         </ol>
                    </div></div>
                    <?php
                    $stt++;
                    }
                    
            ?>

           
             
            
            <?php 
        }
    ?>




   
<?php
    
   


// hàm lấy loại hiển thị
function lay_loai_hien_thi($id_bai_tap_user){
    global $conn;
    $sql = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
    $kq = mysqli_query($conn,$sql);
    if(mysqli_num_rows($kq)>0){
        $row = mysqli_fetch_array($kq);
        $id_cau_hoi = $row['id_cau_hoi'];
        $sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`='$id_cau_hoi'";
        $kq = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($kq);
        return $row;
    }
}
// hàm lấy thứ tự câu hỏi
function thu_tu_cau_hoi($id_cau_hoi,$stt,$bang){
    global $conn;
    $sql = "SELECT `ten_dap_an` FROM `$bang` WHERE `id_cau_hoi`='$id_cau_hoi' and `stt`='$stt'";
    $kq= mysqli_query($conn,$sql);
    if(mysqli_num_rows($kq)>0){
        $row = mysqli_fetch_array($kq);
        return $row;
    }
    
}
function lay_ten_ho_tro($a){
    $kq="";
    if($a!=null){
        if(count($a)>0){
       
            for ($i=0; $i < count($a) ; $i++) { 
                if($a[$i] ==1){
                    $kq.= "<li>Hỗ trợ đọc hiểu đề</li>";
                }
                elseif($a[$i] ==2){
                    $kq.= "<li>Hỗ trợ đặt tính theo hàng</li>";
                }
               
                elseif($a[$i] ==11){
                    $kq.= "<li>Hỗ trợ que tính</li>";
                }
                elseif($a[$i] ==12){
                    $kq.= "<li>Hỗ trợ lego</li>";
                }
                elseif($a[$i] ==13){
                    $kq.= "<li>Hỗ trợ bảng số</li>";
                }
                elseif($a[$i] ==14){
                    $kq.= "<li>Hỗ trợ tia số</li>";
                }
                elseif($a[$i] ==7){
                    $kq.= "<li>Hỗ trợ đọc kết quả giải bài</li>";
                }
                elseif($a[$i] ==8){
                    $kq.= "<li>Hỗ trợ cá sấu</li>";
                }
                elseif($a[$i] ==9){
                    $kq.= "<li>Hỗ trợ ghép ảnh</li>";
                }
                elseif($a[$i] ==3){
                    $kq.= "<li>Hỗ trợ đọc hiểu cách tính</li>";
                }
                elseif($a[$i] ==4){
                    $kq.= "<li>Hỗ trợ hiển thị phép tính</li>";
                }
            }
        }else{
            $kq.= "Không dùng hỗ trợ";
        }
    }
    else{
        $kq.= "Không dùng hỗ trợ";
    }
    return $kq;
}
?>
</body>
</html>