<?php
  session_start();
  include '../../connectdb.php';
  if(!isset($_SESSION['id_user'])){
      header('Location: index.php');
      die();
  }
 
  $role=$_SESSION['quyen'];
  $id_user = $_SESSION['id_user'];

  $id_bai_hoc=$_GET['id_bai_hoc'];
  // $id_user = $_GET['id_user'];
  // $role = $_GET['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web</title>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
        }

        body::-webkit-scrollbar{
            width: 0;
        }

        * {
            color: white;
            font-size: 20px;
            font-weight: bold;
            box-sizing: border-box;
        }

        .border {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .flex-container {
            margin-top: 100px;
            display: flex;
            gap: 150px;
        }

        .box {
            width: 300px;
            background-color: white;
            position: relative;
            border: 4px outset black;
            border-radius: 50px;
            padding: 5px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        img {
            width: 100%;
            height: 100%;
            z-index: -1;
            border-radius: 50px;
            transition: transform 0.3s ease;
        }

        .d {
            border-left: 20px solid red;
            background-color: #464646;
            bottom: 70%;
            opacity: 0.9;
            font-weight: lighter;
            color: white;
            position: absolute;
            padding: 10px;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .b {
            position: absolute;
            bottom: 40%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 10px;
            z-index: 1;
            opacity: 0;
            transition: background-color 0.3s ease;
        }

        .box:hover .b {
            z-index: 2;
            background-color: #464646;
            opacity: 1;
            border-radius: 30px;
        }

        .box:hover {
            border: 4px outset black;
            border-radius: 50px;
            padding: 5px;
        }

        .box:hover img {
            transform: scale(1.1);
        }

        h1 {
            color: black;
            text-align: center;
            font-size: 40px;
        }

        .box a {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 24px;
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .goback-button {
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .box:hover a {
            opacity: 1;
        }
    </style>
</head>

<body>
<div>
    <button class="goback-button" onclick="goBack()">Quay lại</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>
<?php
// $baseUrl = "display_images.php?book=";
// $lessonParam = "&lesson=" . urlencode($_GET["folder"]);
?>

<div class="flex-container">
    <a href="display_images.php?id_bo_sach=2&id_bai_hoc=<?php echo $id_bai_hoc; ?>" class="box">
        <img src="../../assets/image/cat-1.png">
        <span class="b">Chi tiết</span>
        <div class="d">Kết nối tri thức</div>
    </a>
    <a href="display_images.php?id_bo_sach=1&id_bai_hoc=<?php echo $id_bai_hoc; ?>" class="box">
        <img src="../../assets/image/cat-2.jpg">
        <span class="b">Chi tiết</span>
        <div class="d">Cánh diều</div>
    </a>
    <a href="display_images.php?id_bo_sach=3&id_bai_hoc=<?php echo $id_bai_hoc; ?>" class="box">
        <img src="../../assets/image/cat-3.jpg">
        <span class="b">Chi tiết</span>
        <div class="d">Chân trời sáng tạo</div>
    </a>
</div>

</body>

</html>
