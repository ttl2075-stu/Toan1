<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
</head>

<body>
    <a href="nhap_cau_hoi.php">Trở về</a>
    <?php 
    $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
//    for ($i=0; $i <10 ; $i++) { 
//         $sql="INSERT INTO `dap_an_d6k2` (`id_dap_an_matching`, `ten_dap_an_matching`, `id_cau_hoi`,`url_anh`) VALUES (NULL, 'hai$i', '1', '1')";
//         if(mysqli_query($conn, $sql)){
//             echo "Chèn thành công";
//         }
//    }
                
    $sl_cap= $_GET['sl_capa'];
    $id_cau_hoi=$_GET['id_cau_hoi'];
    // echo $id_cau_hoi;
    // echo $sl_cap;
    ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <?php
       echo "<input type='hidden' name='sl_capa' value='$sl_cap'>";
       echo "<input type='hidden' name='id_cau_hoi' value='$id_cau_hoi'>";
        
        
         for ($i=0; $i <($sl_cap*2); $i++) { 
            
            if($i<$sl_cap){
                echo "Biểu thức $i"."<input type='text' name='ch$i' id=''>"."<input type='file' name='anh$i'><br>";

            }else{
                echo "Đáp án $i"."<input type='text' name='ch$i' id=''>"."<input type='file' name='anh$i'><br>";
            }

        }
       
       
        echo "<input type='submit' name='nhap' value='Nhập'>";
        
    ?>

    </form>
    <?php
         
        if(isset($_POST['nhap'])){
            // echo "0ke";
            $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
            $id_cau_hoi=$_GET['id_cau_hoi'];
           
            $target_dir = "uploads/";
            $i=0;
            // Lặp qua từng tệp được tải lên
            foreach($_FILES as $file) {
                 $ch="ch$i";
                //  echo $i;
                 $i++;
                 $da=$_POST[$ch];
                // Lấy thông tin về tên tệp
                $target_file = $target_dir . basename($file["name"]);
                // echo $da. $target_file;
                $sql="INSERT INTO `dap_an_d6k2` (`id_dap_an_matching`, `ten_dap_an_matching`, `id_cau_hoi`,`url_anh`) VALUES (NULL, '$da', '$id_cau_hoi', '$target_file')";
                // echo "Vào vòng 1";
                if(mysqli_query($conn, $sql)){
                    echo "Chèn thành công";
                }
                // Di chuyển tệp tải lên vào thư mục lưu trữ
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.";
                } else {
                    echo "Đã xảy ra lỗi khi tải lên tệp.";
                }
               
            }
           
                            

        }
    ?>
</body>

</html>