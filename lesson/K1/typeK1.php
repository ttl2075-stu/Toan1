<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form">
        <h3>Biểu mẫu Đăng ký</h3>

        <form action="" method="post" id="form">
            <label>Nhập số câu hỏi</label>
            <div>
                <input type="number" name="numQuestion" id="numQuestion" value="<?php if (isset($_POST['numQuestion'])) echo $_POST['numQuestion']; ?>" min="2" max="8">
                <br>
                <?php
                if (isset($_POST['gui']) && empty($_POST['numQuestion'])) {
                    echo "<span class=\"error\">Không để trống</span>";
                }
                ?>
            </div>
            <input type="submit" value="Gửi" name="gui">
            <input type="submit" value="Nhập lại" name="reset">
            <?php
            $_SESSION['num'] = 0;

            if (isset($_POST['gui'])) {
                if (!empty($_POST['numQuestion'])) {
                    $numQuestion = $_POST['numQuestion'];
                    $_SESSION['num'] = $numQuestion;
                    echo '<h4 for="">Nhập đáp án cho các câu hỏi</h4>';
                    for ($i = 1; $i <= $numQuestion; $i++) {
                        echo "<label>Câu thứ " . $i . ":</label>
                                    <div>
                                        <input type=\"number\" class=\"correctKey\" id=\"numQ{$i}\" min=\"0\" max=\"20\" name=\"number{$i}\" value=\"" . (isset($_POST['number' . $i]) ? $_POST['number' . $i] : $i) . "\">";
                        echo "</div>";
                    }
                    echo '<input type="submit" value="Xuất câu hỏi" name="gui1" onclick="show()">';
                }
            }
            if (isset($_POST['reset'])) {
                header("Location: $_SERVER[PHP_SELF]");
                exit();
            }
            ?>
        </form>
    </div>

    <div class="showQ"></div>

    <div class="container1">
        <div><span>Điểm:&ensp;</span><br><span id="point">0</span></div>
    </div>

    <div class="correctNotice"><img src="correct.gif" alt=""></div>
    <div id="selectObj"></div>

    <script src="script.js"></script>
</body>

</html>