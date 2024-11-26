<?php
  include 'connectdb.php';
  session_start();
  header('Content-Type: application/json');
    
date_default_timezone_set('Asia/Ho_Chi_Minh');
  $id_user = $_POST['id_user'] ?? null; 
  $cauTraLoiPost = $_POST['cauTraLoi'] ?? null;
  $idCauHoiPost = $_POST['idCauHoi'] ?? null;
  $id_bai_tap_user = $_POST['id_bai_tap_user'] ?? null;
  $muc_do_ho_tro = $_POST['mucdo'] ?? null;
  $luu_vet1 = $_POST['luu_vet1'] ?? null;
  $luu_vet1 = json_encode($luu_vet1);

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
  // $conn = mysqli_connect('localhost', 'root', '', 'toan1_host');
  // Kiểm tra kết nối
  // if (!$conn) {
  //   die("Kết nối thất bại: " . mysqli_connect_error());
  // }

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
  $k= 0;
  foreach ($cauTraLoi as $bieuThuc => $giaTri) {
    $da = $giaTri->dapAn;
    $cauTraLoiValues .= "($bieuThuc, $i, $muc_do_ho_tro , $idBtUser,$luu_vet1), ($da, $i, $muc_do_ho_tro, $idBtUser,$luu_vet1)";
    if ($i < sizeof((array) $cauTraLoi)) {
      $cauTraLoiValues .= ', ';
    }
    $i++  ;
    // chấm d6k2
    
    if(cham($bieuThuc,$da)==1){
      $k=$k+1;
    }
  }
 
  // xử lý chấm
    // // check xem bài đấy đã hoàn thành chưa
  $i=$i-1;
  $sql = "INSERT INTO `test`(`so_k`, `so_i`) VALUES ('$k','$i')";
  mysqli_query($conn, $sql);
  if(check_trang_thai_hoan_thanh($idBtUser)==0){
    
    if($i==$k){
        $sql1 = "UPDATE `bai_tap_user` SET `trang_thai`='1',`huong_dan_toi_da`='$muc_do_ho_tro' WHERE `id_bai_tap_user`='$idBtUser'";
        mysqli_query($conn, $sql1);
        cap_nhat_tg($idBtUser,0);
    }
  }
  // else{
  //     if($muc_do_ho_tro<stt_huong_dan($idBtUser)&&$i==$k){
  //         $sql1 = "UPDATE `bai_tap_user` SET `huong_dan_toi_da`='$muc_do_ho_tro' WHERE `id_bai_tap_user`='$idBtUser'";
  //         mysqli_query($conn, $sql1);
  //     }
  // }




  $sql = "INSERT INTO dap_an_nguoi_dung_d6k2(id_dap_an, flag, stt_huong_dan, id_bai_tap_user, luu_vet) VALUES $cauTraLoiValues";

  // Thực hiện truy vấn INSERT INTO
  if (mysqli_query($conn, $sql)) {
    echo json_encode('Nộp bài thành công!');
    exit();
  }

  http_response_code(500);
  echo json_encode('Lỗi không lưu được vào cơ sở dữ liệu');

  // viết hàm c
  function cham($id_bieu_thu,$id_dap_an){
      global $conn;
      $sql ="SELECT * FROM `dap_an_d6k2` WHERE `id_dap_d6k2`='$id_bieu_thu' OR `id_dap_d6k2`='$id_dap_an'";
      $result = mysqli_query($conn, $sql);
      $bieu_thuc = mysqli_fetch_assoc($result);
      $dap_an = mysqli_fetch_assoc($result);
      if($bieu_thuc['flag']==$dap_an['flag']){
        return 1;
      }
      return 0;
     
  }
  function stt_huong_dan($id_bai_tap_user){
    global $conn;
    $sql ="SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
    $result=mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['huong_dan_toi_da'];
}
  // check trạng thái hoàn thành
  function check_trang_thai_hoan_thanh($id_bai_tap_user){
    // nếu bài tập đã hoàn thành thì sẽ trả về 1 còn 0 là chưa hoàn thành
    global $conn;
    $kq=0;
    // $sql = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
    $sql="SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user' AND `trang_thai`=1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        $kq=1;
    } 
    else {
        $kq=0;
    }
    return $kq;
}
function cap_nhat_tg($id_bai_tap_user,$i){
  global $conn;
  $current_time = date('Y-m-d H:i:s');
  if($i==1){
      $sql = "UPDATE `bai_tap_user` SET `tg_bd`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
  }else{
      $sql = "UPDATE `bai_tap_user` SET `tg_kt`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
  }
  mysqli_query($conn,$sql);
}
?>