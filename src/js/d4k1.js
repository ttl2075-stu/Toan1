let lesson = JSON.parse(localStorage.getItem('d4k1_baiDien')) || []

function checkAnswer(){
    check(arrSo[0], arrSo[1], arrSo[2]);
    function check(x, y, z){
        var inputt1_value = document.getElementById('inputt1').value;
        var inputt2_value = document.getElementById('inputt2').value;
        var inputt3_value = document.getElementById('inputt3').value;

        var dataToSend = {
            dapanmot: inputt1_value,
            pheptinh: inputt2_value,
            dapanhai: inputt3_value,
        };

        localStorage.setItem('dulieu', JSON.stringify(dataToSend));

        var dung_input1 = false;
        var dung_input2 = false;
        var dung_input3 = false;

        if (inputt1_value !== "" && x == inputt1_value) {
        dung_input1 = true;
        }

        if (inputt3_value !== "" && z == inputt3_value) {
        dung_input3 = true;
        }

        if (inputt2_value !== "" && y == inputt2_value) {
        dung_input2 = true;
        }

        // Hàm tô màu
        function toMauDapAn(id, dung) {
            if (dung) {
                document.getElementById(id).style.border = "2px solid lightgreen";
                document.getElementById(id).style.boxShadow = "0 0 10px 10px lightgreen";
            } else {
                document.getElementById(id).style.border = "2px solid lightcoral";
                document.getElementById(id).style.boxShadow = "0 0 10px 10px lightcoral";
            }
        }

        // Gọi hàm tô màu
        toMauDapAn("inputt1", dung_input1);
        toMauDapAn("inputt2", dung_input2);
        toMauDapAn("inputt3", dung_input3);
    
        // Phát âm thanh
        var audioUrl;
        if (inputt1_value === "" || inputt3_value === "" || inputt2_value === "" || inputt2_value ==="") {
            playAndHideVideoFalse();
        } else if (x == inputt1_value && z == inputt3_value && y == inputt2_value) {
            playAndHideVideoTrue();
            document.getElementById('inputt1').readOnly = true;
            document.getElementById('inputt2').readOnly = true;
            document.getElementById('inputt3').readOnly = true;
            document.getElementById('check').disabled = true;
            document.getElementById('help').disabled = true;
        } else {
            playAndHideVideoFalse();
        }
    }
}
function playAndHideVideoTrue() {
var noticeTrue = document.querySelector('.Notice_True');
var trueVideo = noticeTrue.querySelector('.trueVideo');
var trueAudio = noticeTrue.querySelector('.trueAudio');

noticeTrue.style.display = 'block';

trueVideo.style.display = 'block';
trueAudio.play();
trueAudio.addEventListener('ended', function() {
    noticeTrue.style.display = 'none';
});
}

function playAndHideVideoFalse() {
var noticeFalse = document.querySelector('.Notice_False');
var falseVideo = noticeFalse.querySelector('.falseVideo');
var falseAudio = noticeFalse.querySelector('.falseAudio');

noticeFalse.style.display = 'block';

falseVideo.style.display = 'block';
falseAudio.play();
// Hide video and notice when it ends
falseAudio.addEventListener('ended', function() {
    noticeFalse.style.display = 'none';
});
}

document.addEventListener('DOMContentLoaded', function() {
var videos = document.querySelectorAll('video');
videos.forEach(function(video) {
    video.addEventListener('loadedmetadata', function() {
        this.controls = false;
    });
});
});