<link rel="stylesheet" href="./assets/css_v2/get_question.css">
<?php
include 'connectdb.php';

$id_bai_hoc = $_POST['bai_hoc'];
$id_user = $_POST['user'];
// echo $id_bai_hoc;
// echo $id_user;
$sql1 = "SELECT * FROM `cau_hoi` WHERE `id_bai_hoc`='$id_bai_hoc' ORDER BY `cau_hoi`.`thoi_gian` DESC";
$result = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result) > 0) {
    echo " <tr>
        <th>Chọn</th>
        <th>STT</th>
        <th>Tên bài</th>
        <th>Thời gian tạo bài</th>
        <th>Trạng thái</th>
        <th>Xem chi tiết</th>
    </tr>";
    $stt = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        $id_cau_hoi = $row["id_cau_hoi"];
        $id_loai_hien_thi = $row["id_loai_hien_thi"];
        echo "<tr>";
        echo "<td><input type='checkbox' class='cau-hoi-checkbox' value='" . $row["id_cau_hoi"] . "'></td>";  // Thêm checkbox
        echo "<td>$stt</td>";
        echo "<td>" . $row["ten_cau_hoi"] . "</td>";
        echo "<td>" . (strtotime($row['thoi_gian']) <= 0 ? "-" : date('d/m/Y H:i:s', strtotime($row["thoi_gian"]))) . "</td>";
        echo (kiem_tra_giao_bai_chua($id_user, $row["id_cau_hoi"], $id_bai_hoc) == 1) ? "<td>Đã giao bài</td>" : "<td>Chưa giao bài</td>";
        // echo "<td><a class='btn_xem_chi_tiet' href='in_cau_hoi.php?id_cau_hoi=" . $row['id_cau_hoi'] . "'><i class='fa-solid fa-eye'></i>Xem chi tiết</a></td>";
        if ($row["id_loai_hien_thi"] == 1) {
            echo "<td><a class= 'btn_xem_chi_tiet' href='in_cau_hoi_d6k1.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";
            // echo "<li><a href='../../in_cau_hoi_d6k1.php?id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
            // echo $row['ten_cau_hoi'];
            // echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 3) {
            //  e thêm onclick
            echo "<td><a class= 'btn_xem_chi_tiet'  onclick='luubien()'  href='in_cau_hoi_d6k3.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";
            //   echo "<li><a href='../../in_cau_hoi_d6k3.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien()' target='ndung1'>";
            //   echo $row['ten_cau_hoi'];
            //   echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 2) {
            echo "<td><a class= 'btn_xem_chi_tiet' onclick='luubien_2()' href='in_cau_hoi.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";

            // echo "<li><a href='../../in_cau_hoi.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
            // echo $row['ten_cau_hoi'];
            // echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 4) {
            // $in = "in_cau_hoi_d7k1";
            echo "<td><a class= 'btn_xem_chi_tiet' href='in_cau_hoi_d7k1.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";

            //   echo "<li><a href='../../in_cau_hoi_d7k1.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
            //   echo $row['ten_cau_hoi'];
            //   echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 5) {
            //  e thêm onclick
            echo "<td><a class= 'btn_xem_chi_tiet'  onclick='luubien()'  href='in_cau_hoi_d1.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";
            //   echo "<li><a href='../../in_cau_hoi_d6k3.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien()' target='ndung1'>";
            //   echo $row['ten_cau_hoi'];
            //   echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 6) {
            //  e thêm onclick
            echo "<td><a class= 'btn_xem_chi_tiet'  onclick='luubien()'  href='in_cau_hoi_d4k1.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";
            //   echo "<li><a href='../../in_cau_hoi_d6k3.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien()' target='ndung1'>";
            //   echo $row['ten_cau_hoi'];
            //   echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 7) {
            //  e thêm onclick
            echo "<td><a class= 'btn_xem_chi_tiet'  onclick='luubien()'  href='in_cau_hoi_d3.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";
            //   echo "<li><a href='../../in_cau_hoi_d6k3.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien()' target='ndung1'>";
            //   echo $row['ten_cau_hoi'];
            //   echo "</a></li>";
        } elseif ($row["id_loai_hien_thi"] == 8) {
            echo "<td><a class= 'btn_xem_chi_tiet' onclick='luubien_2()' href='in_cau_hoi.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i></a></td>";

            // echo "<li><a href='../../in_cau_hoi.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
            // echo $row['ten_cau_hoi'];
            // echo "</a></li>";
        }
        echo "</tr>";
        $stt++;
    }
} else {
    echo "<tr><td colspan='5'>Không có câu hỏi nào</td></tr>";
}
function kiem_tra_giao_bai_chua($id_hs, $cau_hoi, $id_khoa_hoc)
{
    global $conn;
    $sql = "SELECT * FROM `bai_tap_user` WHERE `id_user`='$id_hs' AND `id_cau_hoi`='$cau_hoi' AND `id_khoa_hoc`='$id_khoa_hoc'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {
        return 1;
    } else {
        return 0;
    }
}