<?php
session_start();

// Khởi tạo các biến session nếu chưa tồn tại
if (!isset($_SESSION['problem1'])) {
    $_SESSION['problem1'] = '';
}
if (!isset($_SESSION['problem2'])) {
    $_SESSION['problem2'] = '';
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
            $_SESSION['problem2'] = "<h3>Hiện nay, Gia đình bé có $question3 người và gia đình $question4 có $question5 người. Hỏi gia đình bé nhiều hơn gia đình $question4 mấy người?</h3>";
        } else {
            $_SESSION['problem2'] = "<h3>Hiện nay, Gia đình bé có $question3 người và gia đình $question4 có $question5 người. Hỏi gia đình bé ít hơn gia đình $question4 mấy người?</h3>";
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
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        color: #333;
    }

    /* Style cho button Show Form */
    .showFormBtn {
        background-color: #6a0dad; /* Màu nút */
        color: #fff; /* Màu chữ */
        padding: 10px 20px; /* Kích thước nút */
        border: none; /* Không viền */
        border-radius: 4px; /* Góc bo tròn */
        cursor: pointer; /* Con trỏ khi di chuyển qua nút */
        margin-bottom: 10px; /* Khoảng cách dưới */
    }

    .showFormBtn:hover {
        background-color: #4b0783; /* Màu hover của nút */
    }

    /* Style cho form container */
    .formContainer {
        display: none;
        max-width: 500px;
        margin: 0 auto;
        background-color: #fff;
        padding: 10px;
        border-radius: 20px;
    }

    /* Style cho các label và input */
    .problemForm label {
        margin-bottom: 5px;
        font-weight: bold; /* Đậm chữ */
    }

    .problemForm input[type="text"],
    .problemForm input[type="checkbox"] {
        margin-bottom: 10px;
        padding: 8px;
        border: 1px solid #ccc; /* Viền input */
        border-radius: 4px; /* Góc bo tròn input */
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #6a0dad; /* Màu nút */
        color: #fff; /* Màu chữ */
        border: none; /* Không viền */
        border-radius: 4px; /* Góc bo tròn */
        cursor: pointer; /* Con trỏ khi di chuyển qua nút */
        transition: background-color 0.3s ease; /* Hiệu ứng hover */
    }

    input[type="submit"]:hover {
        background-color: #4b0783; /* Màu hover của nút */
    }
    .note{
        font-style: italic;
        font-weight: 200;
        color: blue;
    }
    </style>
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
    <script>
        const showFormBtn1 = document.getElementById('showFormBtn1');
        const formContainer1 = document.getElementById('formContainer1');
        const showFormBtn2 = document.getElementById('showFormBtn2');
        const formContainer2 = document.getElementById('formContainer2');

        showFormBtn1.addEventListener('click', function() {
            formContainer1.style.display = 'block';
            formContainer2.style.display = 'none';
        });

        showFormBtn2.addEventListener('click', function() {
            formContainer2.style.display = 'block';
            formContainer1.style.display = 'none';
        });
    </script>
</body>
</html>
