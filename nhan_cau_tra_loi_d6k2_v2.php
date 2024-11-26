<?php
include 'connectdb.php';
session_start();
header('Content-Type: application/json');

date_default_timezone_set('Asia/Ho_Chi_Minh');
$id_user = $_POST['id_user'] ?? null; 
$cauTraLoiPost = $_POST['cauTraLoi'] ?? null;
$idCauHoiPost = $_POST['idCauHoi'] ?? null;
$id_bai_tap_user = $_POST['id_bai_tap_user'] ?? null;

if (is_null($id_user)) {
  http_response_code(403);
  echo json_encode('Không có id user.');
  exit();
}
if (is_null($cauTraLoiPost) || is_null($idCauHoiPost)) {
  // Trả về lỗi nếu không có cauTraLoi
  http_response_code(400);
  echo json_encode('Không có câu trả lời hoặc câu hỏi được gửi.');
  exit();
}

$cauTraLoi = json_decode($cauTraLoiPost);
$conn = mysqli_connect('localhost', 'root', '', 'toan1_host');
// Kiểm tra kết nối
if (!$conn) {
  die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra xem id_bai_tap_user đã tồn tại cho id_user và id_cau_hoi tương ứng chưa
$sqlCheckBtUser = "SELECT id_bai_tap_user FROM bai_tap_user WHERE id_user = $id_user AND id_cau_hoi = $idCauHoiPost";
$resultCheckBtUser = mysqli_query($conn, $sqlCheckBtUser);
if ($resultCheckBtUser && mysqli_num_rows($resultCheckBtUser) > 0) {
  $row = mysqli_fetch_assoc($resultCheckBtUser);
  $idBtUser = $row['id_bai_tap_user'];
} else {
  // Nếu chưa tồn tại, thêm mới id_bai_tap_user
  $sqlInsertBtUser = "INSERT INTO bai_tap_user (id_user, id_cau_hoi) VALUES ($id_user, $idCauHoiPost)";
  if (!mysqli_query($conn, $sqlInsertBtUser)) {
    echo json_encode('Không thể lưu vào cơ sở dữ liệu');
    exit();
  }
  // Lấy id_bai_tap_user vừa thêm vào
  $idBtUser = mysqli_insert_id($conn);
}

$cauTraLoiValues = '';
$i = 1;
foreach ($cauTraLoi as $bieuThuc => $giaTri) {
  $cauTraLoiValues .= "($bieuThuc, $i, {$giaTri->stt}, $idBtUser), ({$giaTri->dapAn}, $i, {$giaTri->stt}, $idBtUser)";
  if ($i < sizeof((array) $cauTraLoi)) {
    $cauTraLoiValues .= ', ';
  }
  $i++;
}

$sql = "INSERT INTO dap_an_nguoi_dung_d6k2(id_dap_an, flag, stt_huong_dan, id_bai_tap_user) VALUES $cauTraLoiValues";

// Thực hiện truy vấn INSERT INTO
if (mysqli_query($conn, $sql)) {
  echo json_encode('Nộp bài thành công!');
  exit();
}

http_response_code(500);
echo json_encode('Lỗi không lưu được vào cơ sở dữ liệu');
?>