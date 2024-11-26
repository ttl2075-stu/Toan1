let recognition;
let isRecording = false;
let score = 0;
let questionDisplayed = false;
let isAnswered = false;

/**
 * Hàm sinh số ngẫu nhiên từ 1 đến 100, hiển thị câu hỏi và chuẩn bị cho việc ghi âm.
 */
function generateRandomNumber() {
    const randomNum = Math.floor(Math.random() * 100) + 1;
    document.getElementById("randomNumber").innerHTML = "Đây là số mấy " + randomNum + "?";
    questionDisplayed = true;
    isAnswered = false;
    clearResult();
}

/**
 * Hàm đọc số tiếng Việt.
 */
function speakVietnamese(randomNum) {
    let msg = new SpeechSynthesisUtterance();
    msg.text = randomNum;
    msg.lang = 'vi-VN';
    window.speechSynthesis.speak(msg);
}

/**
 * Hàm bắt đầu ghi âm và xử lý kết quả sau khi kết thúc.
 */
function startRecording() {
    if (isAnswered) {
        document.getElementById("result").innerHTML = "<i>*Bạn đã trả lời đúng rồi. Bấm nút hiện câu hỏi để tiếp tục.</i>";
        return;
    }

    recognition = new webkitSpeechRecognition();
    recognition.lang = 'vi-VN';

    recognition.onstart = function () {
        document.getElementById("recordButton").innerHTML = "Đang thu âm...";
        isRecording = true;
    };

    recognition.onresult = function (event) {
        let result = event.results[0][0].transcript;
        document.getElementById("result").innerHTML = "Kết quả: " + result + "<br>";
        let numResult = findNumbersInString(result)[0];
        let num = findNumbersInString(document.getElementById("randomNumber").textContent)[0];

        if (isNaN(numResult)) {
            document.getElementById("result").style.color = "red";
            document.getElementById("result").innerHTML += " <i>*Bạn phải đọc một số! Hãy bấm bắt đầu thu âm để thử lại!</i>";
        } else {
            if (numResult == num) {
                document.getElementById("result").style.color = "green";
                document.getElementById("result").innerHTML += " - Đọc Đúng!<br> Hãy bấm hiện câu hỏi để chuyển sang câu tiếp theo!";
                increaseScore();
                isAnswered = true;
            } else {
                document.getElementById("result").style.color = "red";
                document.getElementById("result").innerHTML += " - Đọc Sai!<br> Hãy bấm bắt đầu thu âm để thử lại!";
            }
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

/**
 * Hàm tăng điểm khi người chơi đọc đúng số.
 */
function increaseScore() {
    score += 10;
    document.getElementById("points").textContent = score;
}

/**
 * Hàm xóa kết quả trả lời trước đó.
 */
function clearResult() {
    document.getElementById("result").innerHTML = "";
}

// Sự kiện click nút ghi âm
document.getElementById("recordButton").addEventListener("click", function () {
    if (!questionDisplayed) {
        document.getElementById("result").innerHTML = "<i>*Hãy bấm nút hiện câu hỏi trước khi bắt đầu ghi âm.</i>";
        return;
    }

    startRecording();
});

// Sự kiện click nút gợi ý
document.getElementById('helpButton').addEventListener("click", () => {
    if (!questionDisplayed) {
        document.getElementById("result").innerHTML = "<i>*Hãy bấm nút hiện câu hỏi trước khi sử dụng gợi ý.</i>";
        return;
    }

    let num = findNumbersInString(document.getElementById("randomNumber").textContent)[0];
    speakVietnamese(num);
});

function findNumbersInString(str) {
    let numbersArray = str.match(/\d+/g) || [];
    let resultArray = numbersArray.map(num => {
        return parseInt(num, 10);
    })
    return resultArray;
}
