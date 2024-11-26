
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thu Âm và Kiểm Tra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        $id_cau_hoi=$_GET['id_cau_hoi'];
        $id_loai_hien_thi =$_GET['id_loai_hien_thi'];
        echo "Id_cau_hoi: ".$id_cau_hoi;
        echo "id_loai_hien_thi: ".$id_loai_hien_thi;
    ?>
    <div class="container">
        <h1 class="topic_name">Tến</h1>
        <button id="generateButton" ></button>
        <div class="ques">
            <h1>Câu hỏi:</h1>
            <h1 id="randomNumber"></h1>
            
        </div>
        <button id="recordButton"><i class="fa-solid fa-microphone"></i> Bắt đầu thu âm</button>
        <button id="helpButton"><i class="fa-solid fa-lightbulb"></i> Gợi ý</button>
        <p id="result"></p>
        <p id="score">Điểm số: <span id="points">0</span></p>
    </div>
    <script src="script.js">

    </script>
</body>
</html>