<?php
  session_start();
  include '../../connectdb.php';
  if(!isset($_SESSION['id_user'])){
      header('Location: index.php');
      die();
  }
 
  $role=$_SESSION['quyen'];
  $id_user = $_SESSION['id_user'];
  $id_bo_sach= $_GET['id_bo_sach'];
  $id_bai_hoc=$_GET['id_bai_hoc'];
//   echo "id_bo_sach: ".$id_bai_hoc. "Id_bai_hoc: ".$id_bai_hoc;
  // $id_user = $_GET['id_user'];
  // $role = $_GET['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css_v2/style.css">
    <title>Hiển thị Ảnh</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-size: 2rem;
        }

        .border {
            padding: 10px;
        }

        .flex-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .flex-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
            margin: 5px;
        }

        .goback-button {
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 10px;
            background-color: var(--blue);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 2rem;
        }

        .goback-button:hover {
            background-color: var(--yellow);
            color: var(--blue);
        }

        h1 {
            text-align: center;
        }
    </style>

</head>

<body>
    <div class="border">
        <div>
            <button class="goback-button" onclick="goBack()">Quay lại</button>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </div>
        <div class="flex-container">
            <?php
            
            // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
           
            $sql = "SELECT * FROM `links` WHERE `ma_bai_hoc`='$id_bai_hoc' AND `id_bo_sach`='$id_bo_sach'";
            $result=mysqli_query($conn, $sql);
            // $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_assoc($result);
                
                // print_r($row['link']);
                $anh=$row['link']."*";
                // echo $anh;
                foreach (glob("$anh") as $filename) {
                    // echo "$filename"."<br>"; 
                    echo "<img src='$filename' >";
                }
                // $role=$row['quyen'];
                // $id_user = $row['id_user'];
                // echo $id_user;   
                // header("Location:nhap_cau_hoi.php?role=$role&id_user=$id_user");
            }else{
                echo "Tài liệu đang trong quá trình cập nhật";
            }
                        //   "../../book/1. KNTT/1. Số và phép tính/1.1. Số tự nhiên/1.1.1. Các số từ 0 - 10/1.1.1.1. Các số 0, 1, 2, 3, 4, 5/"
            // foreach (glob("../../book/1. KNTT/1. Số và phép tính/1.1. Số tự nhiên/1.1.1. Các số từ 0 - 10/Các số 0, 1, 2, 3, 4, 5/*") as $filename) {
            //     echo "$filename"."<br>"; 
            //     echo "<img src='$filename' >";
            // }
            ?>
        </div>
    </div>
</body>

</html>
                