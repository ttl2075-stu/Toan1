<!DOCTYPE html>
<html lang="en">
<?php 
$DB_HOST = 'localhost'; // tên host
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'quan_ly_bai_hoc'; // tên database
// myspl_connect // kết nối php với mysql
$conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
if($conn){
    mysqli_query($conn,"SET NAMES 'utf8'");
}
session_start();
if (!isset($_SESSION['problem3'])) {
    $_SESSION['problem3'] = '';
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div id="form">
<button class="showFormBtn" id="exit"><a href="box.php">Thoat</a></button>
    <h2><u>Tình huống 3:</u> Tình huống đếm số lượng</h2>
    <p class="note">*Phụ huynh điền form để tạo bài phù hợp cho bé</p>
    <div class="formContainer" id="formContainer3">
        <fieldset>
            <legend>Cung cấp thông tin</legend>
            <form class="problemForm" id="problemForm3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="question6">Chọn đồ vật hoặc con vật bé hay tiếp xúc: </label>
                <br>
                <br>
            <div id="box_so_thich"> 
            <?php 
                $sql = "SELECT * FROM `so_thich`";
                $a = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($a)){
                    echo "<div class='so_thich'>";
                        echo "<input type='checkbox' name='sothich' value='" . $row['So_thich'] . "'>";
                        echo "<label for='" .$row['So_thich'] ."'>" .$row['So_thich'];
                        echo "</label>";
                    echo "</div>";
                }
                echo "<div class='so_thich'>";
                    echo "<input type='checkbox' name='sothich' value=''>";
                    echo "<input type='text' id='khac' placehoder='Khac'>";
                echo "</div>";
                ?>

            </div>
            <input type="submit" value="Submit" id="submit3" name="submit3">
            </form>
        </fieldset>
    </div>
    <div id="problemContainer3">
        <?php echo $_SESSION['problem3']; ?>
    </div>
</div>
<?php 
    mysqli_close($conn);
    ?>
    
</body>
</html>