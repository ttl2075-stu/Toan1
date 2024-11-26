<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Options</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form">
        <h3>Biểu mẫu Đăng ký</h3>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form">
            <label for="numQuestion">Nhập số câu hỏi</label>
            <div>
                <input type="number" name="numQuestion" id="numQuestion" value="<?php if (isset($_POST['numQuestion'])) echo $_POST['numQuestion']; ?>" min="2" max="8">
                <br>
                <?php
                if (isset($_POST['gui']) && empty($_POST['numQuestion'])) {
                    echo "<span class=\"error\">Không để trống</span>";
                }
                ?>
            </div>
            <label>Dạng bài</label>
            <div style="display: block">
                <div>
                    <input type="radio" name="dang" id="dang1" value="dang1" <?php if (isset($_POST['dang']) && $_POST['dang'] == 'dang1') echo 'checked'; ?>>
                    <label for="dang1">Trả lời 1 lần</label> <br>
                    <input type="radio" name="dang" id="dang2" value="dang2" <?php if (isset($_POST['dang']) && $_POST['dang'] == 'dang2') echo 'checked'; ?>>
                    <label for="dang1">Trả lời nhiều lần có trừ điểm nếu trả lời sai</label> <br>
                    <input type="radio" name="dang" id="dang3" value="dang3" <?php if (isset($_POST['dang']) && $_POST['dang'] == 'dang3') echo 'checked'; ?>>
                    <label for="dang1">Trả lời nhiều lần không trừ điểm</label> <br>
                    <?php
                    if (isset($_POST['gui']) && empty($_POST['dang'])) {
                        echo "<span class=\"error\">Vui lòng chọn</span>";
                    }
                    ?>
                </div>
            </div>
            <input type="submit" value="Gửi" name="gui">
            <input type="submit" value="Nhập lại" name="reset">

            <?php
            $_SESSION['num'] = 0;

            if (isset($_POST['gui'])) {
                if (!empty($_POST['numQuestion']) && !empty($_POST['dang'])) {
                    $numQuestion = $_POST['numQuestion'];
                    $_SESSION['num'] = $numQuestion;
                    echo '<h4 for="">Nhập đáp án cho các câu hỏi</h4>';
                    for ($i = 1; $i <= $numQuestion; $i++) {
                        echo "<label>Câu thứ " . $i . ":</label>
                <div>
                    <input type=\"number\" class=\"correctKey\" id=\"numQ{$i}\" min=\"0\" max=\"10\" name=\"number{$i}\" value=\"" . (isset($_POST['number' . $i]) ? $_POST['number' . $i] : $i) . "\">";

                        // Tạo mảng chứa các giá trị của option
                        $currentNumber = isset($_POST['number' . $i]) ? $_POST['number' . $i] : $i;
                        $options = [];

                        if ($currentNumber == 0 || $currentNumber == 1) {
                            $options = ["Trường hợp 1"];
                        } elseif (in_array($currentNumber, [2, 4, 5, 8, 10])) {
                            $options = ["Trường hợp 1", "Trường hợp 2"];
                        } else {
                            $options = ["Trường hợp 1", "Trường hợp 2", "Trường hợp 3"];
                        }

                        // Tạo select và option
                        echo "<select name=\"select{$i}\" id=\"select{$i}\">";
                        foreach ($options as $optionValue) {
                            echo "<option value=\"$optionValue\"";
                            echo isset($_POST['select' . $i]) && $_POST['select' . $i] == $optionValue ? " selected" : "";
                            echo ">$optionValue</option>";
                        }
                        echo "</select>";
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
        <div>
            <span>Điểm:&ensp;</span><br><span id="point">0</span>
            <p></p>
        </div>
    </div>

    <div class="correctNotice"><img src="correct.gif" alt=""></div>

    <div class="container2">
        <script>
            function updateOptions(num, selectId) {
                var select = document.getElementById(selectId);
                var options = [];

                if (num == 0 || num == 1) {
                    options = ["Trường hợp 1"];
                } else if (num == 2 || num == 4 || num == 5 || num == 8 || num == 10) {
                    options = ["Trường hợp 1", "Trường hợp 2"];
                } else {
                    options = ["Trường hợp 1", "Trường hợp 2", "Trường hợp 3"];
                }

                // Xóa các option hiện tại
                while (select.firstChild) {
                    select.removeChild(select.firstChild);
                }

                // Thêm các option mới
                options.forEach(function(optionValue) {
                    var option = document.createElement("option");
                    option.value = optionValue;
                    option.text = optionValue;
                    select.appendChild(option);
                });
            }
        </script>
        <input type="button" value="Lựa chọn đối tượng" onclick="showSelectObj()">
    </div>

    <div id="selectObj"></div>

    <script src="kichban.js"></script>
    <script src="script.js"></script>
</body>

</html>