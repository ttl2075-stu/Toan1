<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['problem'])) {
    $_SESSION['problem'] = '';
}

if (isset($_POST["submit2"])) {
    $question3 = $_POST["question3"];
    $question4 = $_POST["question4"];
    $question5 = $_POST["question5"];

    if ($question3 == $question5) {
        $_SESSION['problem'] = "Gia đình 2 bé có bằng nhau không
        <button id='recordButton' onclick='startRecording()'><i class='fa-solid fa-microphone'></i> Bắt đầu thu âm</button>
        ";
    } else {
        $diff = abs($question3 - $question5);
        if ($question3 > $question5) {
            $_SESSION['problem'] = "<h3>Hiện nay, Gia đình bé có $question3 người và gia đình $question4 có $question5 người. Hỏi gia đình bé nhiều hơn gia đình $question4 mấy người?</h3>
            <button id='recordButton' onclick='startRecording()'><i class='fa-solid fa-microphone'></i> Bắt đầu thu âm</button>
            ";
        } else {
            $_SESSION['problem'] = "<h3>Hiện nay, Gia đình bé có $question3 người và gia đình $question4 có $question5 người. Hỏi gia đình bé ít hơn gia đình $question4 mấy người?</h3>
            <button id='recordButton' onclick='startRecording()'><i class='fa-solid fa-microphone'></i> Nhấn đề trả lời</button>
            ";
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<button class="showFormBtn" id="exit"><a href="box.php">Thoat</a></button>
<button class="showFormBtn" id="return" style='display:none'>Điền lại form</button>
<div id="form">
    <h2><u>Tình huống 2:</u> Tình huống so sánh số người</h2>
    <p class="note">*Phụ huynh điền form để tạo bài phù hợp cho bé</p>
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
    <div id="problemContainer">
        <?php echo $_SESSION['problem']; ?>
    </div>
    <div id="result"></div>
</div>
<script>
let isRecording = false;
let isAnswered = false;
let recognition;
let answer = "";

function startRecording() {
    recognition = new webkitSpeechRecognition();
    recognition.lang = 'vi-VN';

    recognition.onstart = function () {
        document.getElementById("recordButton").innerHTML = "Đang thu âm...";
        isRecording = true;
    };

    recognition.onresult = function (event) {
        let result = event.results[0][0].transcript;
        answer = result;
        document.getElementById("result").innerHTML = "Kết quả: " + result + "<br>";
        if(<?php echo $question3 == $question5?>){
            if((answer.trim().toLowerCase()) === "có"){
                document.getElementById("result").style.color = "green";
                document.getElementById("result").innerHTML += " - Đọc Đúng!<br> Hãy tạo thêm đ!";
                isAnswered = true;
            }else{
                document.getElementById("result").style.color = "red";
                document.getElementById("result").innerHTML += "- Đọc Sai!<br> Hãy bấm bắt đầu thu âm để thử lại!";
            }
        }else{
            if ((answer.trim().toLowerCase()) === "<?php echo $diff; ?>") {
            document.getElementById("result").style.color = "green";
            document.getElementById("result").innerHTML += " - Đọc Đúng!<br> Hãy tạo thêm đ!";
            isAnswered = true;
            } else {
                document.getElementById("result").style.color = "red";
                document.getElementById("result").innerHTML += " - Đọc Sai!<br> Hãy bấm bắt đầu thu âm để thử lại!";
            }

            document.getElementById("recordButton").innerHTML = "Bắt đầu thu âm";
            isRecording = false;
        }
    };

    recognition.onend = function () {
        if (isRecording) {
            recognition.start();
        }
    };
    recognition.start();
}

var showFormBtn = document.getElementById('return');
var exit = document.getElementById('exit');
var ketqua = document.getElementById('problemContainer');
var form = document.getElementById('form');


// .addEventListener('click', function() {
//     ketqua.style.display ='block';
//     showFormBtn.style.display = 'block';
//     form.style.display ='none';
// });

showFormBtn.addEventListener('click', function() {
    ketqua.style.display ='none';
    showFormBtn.style.display ='none';
    form.style.display ='block';

});


</script>
</body>
</html>