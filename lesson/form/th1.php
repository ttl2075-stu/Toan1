<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['problem'])) {
    $_SESSION['problem'] = '';
}

if (isset($_POST["submit1"])) {
    $question1 = $_POST["question1"];
    $question2 = $_POST["question2"];

    $difference = abs($question1 - $question2);
    if ($question1 > $question2) {
        $_SESSION['problem'] = "<h3>Hiện nay, bố bạn $question1 tuổi và bố lớn hơn mẹ $difference tuổi. Hỏi hiện nay, mẹ bạn bao nhiêu tuổi?</h3>
        <button id='recordButton' onclick='startRecording()'><i class='fa-solid fa-microphone'></i> Nhấn để trả lời</button>
        <div id='result'></div>
        ";
    } else {
        $_SESSION['problem'] = "<h3>Hiện nay, bố bạn $question1 tuổi và bố kém hơn mẹ $difference tuổi. Hỏi hiện nay, mẹ bạn bao nhiêu tuổi?</h3>
        <button id='recordButton' onclick='startRecording()'><i class='fa-solid fa-microphone'></i> Nhấn để trả lời</button>
        <div id='result'></div>
        ";
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>
    <button class="showFormBtn" id="exit"><a href="box.php">Thoat</a></button>
    <button class="showFormBtn" id="return" style='display:none'>Điền lại form</button>
    <div id="form">
        <h2><u>Tình huống 1:</u> Tình huống tính số tuổi</h2>
        <p class="note">*Phụ huynh điền form để tạo bài phù hợp cho bé</p>
        <div class="formContainer" id="formContainer1">
            <fieldset>
                <legend>Cung cấp thông tin</legend>
                <form class="problemForm" id="problemForm1" method="post" action="">
                    <label for="question1">Bố của bé bao nhiêu tuổi?</label>
                    <input type="text" id="question1" name="question1"><br><br>
                    <label for="question2">Mẹ của bé bao nhiêu tuổi?</label>
                    <input type="text" id="question2" name="question2"><br><br>
                    <input type="submit" value="Submit" id="submit1" onclick="kq()" name="submit1">
                </form>
            </fieldset>
        </div>
        <div id="problemContainer">
            <?php echo $_SESSION['problem']; ?>
        </div>
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
        if ((answer.trim().toLowerCase()) === "<?php echo $question2; ?>") {
            document.getElementById("result").style.color = "green";
            document.getElementById("result").innerHTML += " - Đọc Đúng!<br> Hãy tạo thêm đ!";
            isAnswered = true;
        } else {
            document.getElementById("result").style.color = "red";
            document.getElementById("result").innerHTML += " - Đọc Sai!<br> Hãy bấm bắt đầu thu âm để thử lại!";
        }

        document.getElementById("recordButton").innerHTML = "Bắt đầu thu âm";
        isRecording = false;
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

function kq(){
    console.log(3);
    ketqua.style.display ='block';
    showFormBtn.style.display = 'block';
    form.style.display ='none';
}

showFormBtn.addEventListener('click', function() {
    ketqua.style.display ='none';
    showFormBtn.style.display ='none';
    form.style.display ='block';

});

</script>
</body>
</html>