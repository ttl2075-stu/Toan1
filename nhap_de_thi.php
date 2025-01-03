<?php
session_start();
include 'connectdb.php';
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    die();
}
$role = $_SESSION['quyen'];
$id_user = $_SESSION['id_user'];
$id_khoa_hoc = $_GET['id_khoa_hoc'];
?>
<h1>Lựa chọn học sinh</h1>
<select name="user" id="user" onchange="loadQuestions()">
    <?php
    $sql = "SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `user` WHERE `id_khoa_hoc`='$id_khoa_hoc' AND `thanh_vien_khoa_hoc`.`id_user` = `user`.`id_user` AND `user`.`quyen`=2";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['id_user'] . "'>" . $row['ten'] . "</option>";
        }
    }

    ?>
</select>
<link rel="stylesheet" href="./assets/css_v2/giao_bai_tap.css">
<style>
/* Định dạng bảng câu hỏi */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: center;
}

table th,
table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

table th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
}

/* Thay đổi màu nền các dòng xen kẽ trong bảng */
table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Thêm màu khi người dùng rê chuột vào dòng */
table tr:hover {
    background-color: #f1f1f1;
}

.ten-bai {
    text-align: justify !important;
}

/* Định dạng nút "Xem chi tiết" */
.btn_xem_chi_tiet {
    background: var(--white) !important;
    border: 1px solid var(--blue);
    color: var(--blue);
    border-radius: 6px;
    box-shadow: rgba(0, 0, 0, 0.1) 1px 2px 4px;
    box-sizing: border-box;
    cursor: pointer;
    display: inline-block;
    font-weight: 800;
    min-height: 40px;
    outline: 0;
    padding: 10px;
    text-align: center;
    text-rendering: geometricprecision;
    text-transform: none;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    vertical-align: middle;
}
.btn_xem_chi_tiet:hover,
.btn_xem_chi_tiet:active {
    color: var(--white);
    background-color: var(--blue) !important;
    background-color: initial;
    background-position: 0 0;
}
.btn_xem_chi_tiet:active {
    opacity: 0.5;
}

/* .btn_xem_chi_tiet {
    display: inline-block;
    padding: 8px 12px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.btn_xem_chi_tiet:hover {
    background-color: #2980b9;
} */

/* Định dạng icon trong nút */
/* .btn_xem_chi_tiet i {
    margin-right: 6px;
} */

/* Thông báo khi không có câu hỏi */
td[colspan="4"] {
    text-align: center;
    font-style: italic;
    color: #999;
    font-size: 16px;
}

/* Định dạng chung cho trang */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 20px;
}

h1 {
    font-size: 24px;
    color: #333;
    margin-bottom: 10px;
}

select {
    padding: 8px;
    font-size: 16px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Thêm khoảng cách giữa các thẻ chọn */
select+select {
    margin-left: 20px;
}

/* Định dạng thông báo lỗi hoặc thành công */
.alert {
    padding: 10px;
    background-color: #f44336;
    color: white;
    margin-bottom: 15px;
}

.alert.success {
    background-color: #4CAF50;
}

.alert.info {
    background-color: #2196F3;
}

.alert.warning {
    background-color: #ff9800;
}

.alert.close {
    float: right;
    font-size: 20px;
    line-height: 20px;
    cursor: pointer;
}
</style>
<h1>Lựa chọn bài học</h1>
<select name="bai_hoc" id="bai_hoc" onchange="loadQuestions()">
    <?php
    $sql = "SELECT * FROM `bai_hoc`";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['ma_bai_hoc'] . "'>" . $row['ten_bai_hoc'] . "</option>";
        }
    }
    ?>
</select>
<input type="hidden" id="id_nguoi_giao" name="" <?php echo "value='$id_user'" ?>>
<input type="hidden" id="id_khoa_hoc" name="" <?php echo "value='$id_khoa_hoc'" ?>>
<button type="button" onclick="giaoBai()" class="btn_giao_bai">Giao bài</button> <!-- Nút giao bài -->
<h1>Danh sách câu hỏi</h1>
<table id="questions_table">
    <tr>
        <th>Chọn</th>
        <th>STT</th>
        <th>Tên bài</th>
        <th>Thời gian tạo bài</th>
        <th>Trạng thái</th>
        <th>Xem chi tiết</th>
    </tr>
    <!-- Dữ liệu câu hỏi -->
</table>
<style>
tr td:nth-child(3) {
    text-align: left;
}
</style>

<script>
function loadQuestions() {
    var user = document.getElementById("user").value;
    var bai_hoc = document.getElementById("bai_hoc").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "get_questions.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("questions_table").innerHTML = xhr.responseText;
        }
    };
    xhr.send("user=" + user + "&bai_hoc=" + bai_hoc);
}

function giaoBai() {
    var selectedQuestions = [];
    var checkboxes = document.querySelectorAll('.cau-hoi-checkbox:checked');

    checkboxes.forEach(function(checkbox) {
        selectedQuestions.push(checkbox.value); // Lấy giá trị của câu hỏi được chọn
    });

    if (selectedQuestions.length === 0) {
        alert("Vui lòng chọn ít nhất một câu hỏi để giao!");
        return;
    }

    var user = document.getElementById("user").value;
    var bai_hoc = document.getElementById("bai_hoc").value;
    var id_khoa_hoc = document.getElementById("id_khoa_hoc").value;
    var id_nguoi_giao = document.getElementById("id_nguoi_giao").value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "giao_bai.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Giao bài thành công!");
            // Có thể cập nhật lại trang nếu cần
        }
    };
    xhr.send("user=" + user + "&id_nguoi_giao=" + id_nguoi_giao + "&id_khoa_hoc=" + id_khoa_hoc + "&bai_hoc=" +
        bai_hoc + "&questions=" + JSON.stringify(selectedQuestions));
}
window.onload = function() {
    loadQuestions();
};
</script>