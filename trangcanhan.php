<!DOCTYPE html>
<?php 
include 'connectdb.php';
session_start();
$role=$_SESSION['quyen'];
$id_user = $_SESSION['id_user'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Trang cá nhân</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Inter", sans-serif;
}

h1{
    text-align: center;
}

body::-webkit-scrollbar{
    width: 0;
}
        table{
        background-color: var(--blue);
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
        border-radius: 10px; 
        overflow: hidden; 
        /* box-shadow: 0px 0px 10px 10px var(--sky);  */
        background-color: var(--white);
        overflow-y: auto;
        margin-bottom: 10px;
    }

tr{
    border: 1px soild green;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px soild black;
}

th {
    background-color: var(--color);
    color: var(--container);
    font-size: 25px;
}

tr:nth-child(even){
    background-color: #b3e3f7;
}
tr:nth-child(even):hover{
    background-color:#cee9be;
    cursor: pointer;
    font-weight: bold;
    font-size: 20px;
    
}
table tr:nth-child(odd):not(:first-child):hover {
    background-color: #3681ab;
    cursor: pointer;
    font-weight: bold;
    font-size: 20px;
    color:white;
}

.stt{
    text-align: center;
    width: 50px;
}
    </style>
</head>
<body>
    <H1>Trang cá nhân</H1>
    <?php 
    $sql = "SELECT * FROM bai_hoc";
    $result = mysqli_query($conn, $sql);
    $table = '<table border="1">';
    $table .= '<tr><th class="stt">STT</th><th>Tên bài học</th><th>Trạng thái</th><th>Tổng phần thưởng</th></tr>';
    if (mysqli_num_rows($result) > 0) {
        $stt = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $ten_bai_hoc = $row['ten_bai_hoc'];
            $table .= "<tr><td class='stt'>$stt</td><td>$ten_bai_hoc</td><td>Trạng thái</td><td>Tổng phần thưởng</td></tr>";
            $stt++;
        }
    }else{
        $table .= "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
    }
    $table .= '</table>';   
    echo $table;
    ?>
</body>
</html>