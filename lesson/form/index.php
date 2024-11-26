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

// Khởi tạo các biến session nếu chưa tồn tại
if (!isset($_SESSION['problem1'])) {
    $_SESSION['problem1'] = '';
}
if (!isset($_SESSION['problem2'])) {
    $_SESSION['problem2'] = '';
}

if (!isset($_SESSION['problem3'])) {
    $_SESSION['problem3'] = '';
}

if (isset($_POST["submit1"])) {
    $question1 = $_POST["question1"];
    $question2 = $_POST["question2"];

    $difference = abs($question1 - $question2);
    if ($question1 > $question2) {
        $_SESSION['problem1'] = "<h3>Hiện nay, bố bạn $question1 tuổi và bố lớn hơn mẹ $difference tuổi. Hỏi hiện nay, mẹ bạn bao nhiêu tuổi?</h3>";
    } else {
        $_SESSION['problem1'] = "<h3>Hiện nay, bố bạn $question1 tuổi và bố kém hơn mẹ $difference tuổi. Hỏi hiện nay, mẹ bạn bao nhiêu tuổi?</h3>";
    }
}

if (isset($_POST["submit2"])) {
    $question3 = $_POST["question3"];
    $question4 = $_POST["question4"];
    $question5 = $_POST["question5"];

    if ($question3 == $question5) {
        $_SESSION['problem2'] = "Gia đình 2 bé bằng nhau";
    } else {
        $diff = abs($question3 - $question5);
        if ($question3 > $question5) {
            $_SESSION['problem2'] = "<h3>Hiện nay, Gia đình bé có $question3 người và gia đình $question4 có $question5 người. Hỏi gia đình bé nhiều hơn gia đình $question4 mấy người?</h3>
            <button id='recordButton'><i class='fa-solid fa-microphone'></i> Bắt đầu thu âm</button>
            ";
        } else {
            $_SESSION['problem2'] = "<h3>Hiện nay, Gia đình bé có $question3 người và gia đình $question4 có $question5 người. Hỏi gia đình bé ít hơn gia đình $question4 mấy người?</h3>
            <button id='recordButton'><i class='fa-solid fa-microphone'></i> Nhấn đề trả lời</button>
            ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Problem</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>
    <div>
        <h2><u>Tình huống 1:</u> Tình huống tính số tuổi</h2>
        <p class="note">*Phụ huynh điền form để tạo bài phù hợp cho bé</p>
        <button class="showFormBtn" id="showFormBtn1">Điền form</button>
        <div class="formContainer" id="formContainer1">
            <fieldset>
                <legend>Cung cấp thông tin</legend>
                <form class="problemForm" id="problemForm1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="question1">Bố của bé bao nhiêu tuổi?</label>
                    <input type="text" id="question1" name="question1"><br><br>
                    <label for="question2">Mẹ của bé bao nhiêu tuổi?</label>
                    <input type="text" id="question2" name="question2"><br><br>
                    <input type="submit" value="Submit" id="submit1" name="submit1">
                </form>
            </fieldset>
        </div>
        <div id="problemContainer1">
            <?php echo $_SESSION['problem1']; ?>
        </div>
    </div>
    <div>
        <h2><u>Tình huống 2:</u> Tình huống so sánh số người</h2>
        <p class="note">*Phụ huynh điền form để tạo bài phù hợp cho bé</p>
        <button class="showFormBtn" id="showFormBtn2">Điền form</button>
        <div class="formContainer" id="formContainer2">
            <fieldset>
                <legend>Cung cấp thông tin</legend>
                <form class="problemForm" id="problemForm2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="question3">Gia đình bé có bao nhiêu người?</label>
                    <input type="text" id="question3" name="question3"><br><br>
                    <label for="question4">Bạn thân của bé tên gì?</label>
                    <input type="text" id="question4" name="question4"><br><br>
                    <label for="question5">Gia đình bạn ấy có mấy người?</label>
                    <input type="text" id="question5" name="question5"><br><br>
                    <input type="submit" value="Submit" id="submit2" name="submit2">
                </form>
            </fieldset>
        </div>
        <div id="problemContainer2">
            <?php echo $_SESSION['problem2']; ?>
        </div>
    </div>
        <div>
        <h2><u>Tình huống 3:</u> Tình huống đếm số lượng</h2>
        <p class="note">*Phụ huynh điền form để tạo bài phù hợp cho bé</p>
        <button class="showFormBtn" id="showFormBtn3">Điền form</button>
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
    <script>
        
    </script>
    <?php 
    mysqli_close($conn);
    ?>
</body>
</html>
