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
        <h3>Nhập câu hỏi</h3>

        <form action="" method="post" id="form">
            <label>Nhập số đối tượng xuất hiện</label>
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
                    for ($i = 0; $i <= $numQuestion; $i++) {
                        echo "
                            <div>
                                <input type=\"button\" onclick=\"toggleQuizSelection({$i})\" class=\"correctKey\" id=\"numQ{$i}\" min=\"0\" max=\"20\" name=\"number{$i}\" value=\"" . (isset($_POST['number' . $i]) ? $_POST['number' . $i] : $i) . "\">";
                        echo "</div>";
                    }
                    echo `<h3>Chọn đối tượng mà bạn yêu thích </h3>`;
            
                    $dir = './uploads'; // Đường dẫn đến thư mục chứa ảnh
                    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif'); // Các loại phần mở rộng được phép
                    $files = scandir($dir);
        
                    echo '<div style="display: flex; flex-wrap: wrap;">'; // Bắt đầu một hàng
        
                    foreach ($files as $index => $file) {
                        $path_info = pathinfo($file);
        
                        if (is_file($dir . '/' . $file) && in_array(strtolower($path_info['extension']), $allowed_extensions)) {
                            echo '<div style="margin: 15px;">';
                            echo '<img onclick="toggleImageSelection(\'' . $dir . '/' . $file . '\', ' . $index . ');" id="image-' . $index . '" class="selectable-image" src="' . $dir . '/' . $file . '" data-src="' . $dir . '/' . $file . '" alt="' . $file . '" style="width: 10vh; height: 10vh;" />';
                            echo '</div>';
                        }
                    }
        
                    echo '</div>'; // Kết thúc hàng
                    echo '<input type="submit" value="Xuất câu hỏi" name="gui1" onclick="show(event)">';
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

    <script src="script.js"></script>
</body>

</html>