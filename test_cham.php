<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test chấm</title>
</head>
<body>
    <h1>Test chấm</h1>
    <?php
        $id_cau_hoi=17;
        $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
        $sql ="SELECT * FROM `dap_an_d6k2` WHERE `id_cau_hoi`=17";
        $kq=mysqli_query($conn,$sql);
        echo "<h2>Danh sách đáp án cho câu hỏi có id_cau_hoi=17</h2>";
        while($row = mysqli_fetch_assoc($kq)) {
            print_r($row);
            echo "<br>";
            // echo "<input type='checkbox' name='chon[]' value='".$row['id_cau_hoi']."'>";
            // echo $row["ten_cau_hoi"]."<a href=' in_cau_hoi.php?id_cau_hoi=".$row['id_cau_hoi']."'>Xem chi tiết</a>"."<br>";
            
        }
        
        $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
        $sql ="SELECT * FROM `dap_an_nguoi_dung`  ORDER BY `flag`";
        $kq=mysqli_query($conn,$sql);

        echo "<h2>Danh sách đáp án người dùng</h2>";
        $i=1;
        $a=[];
        while($row = mysqli_fetch_assoc($kq)) {
            print_r($row);
            $a[]=$row['id_dap_an'];
            echo "<br>";
            // echo "<input type='checkbox' name='chon[]' value='".$row['id_cau_hoi']."'>";
            // echo $row["ten_cau_hoi"]."<a href=' in_cau_hoi.php?id_cau_hoi=".$row['id_cau_hoi']."'>Xem chi tiết</a>"."<br>";
            
        }
        // so khớp để chấm
        print_r($a);
        echo "<br>";
        $flag=1;
        for ($i=0; $i < count($a) ; $i=$i+2) { 
            
            echo $a[$i]."<br>";   
            $j=$a[$i];
          
            $sql ="SELECT * FROM `dap_an_d6k2` WHERE `id_dap_d6k2`=$j";
            $kq=mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($kq);
            $bieu_thuc= $row['flag'];
            $k=$i+1;
            $j=$a[$k];
            $sql ="SELECT * FROM `dap_an_d6k2` WHERE `id_dap_d6k2`=$j";
            $kq=mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($kq);
            $dap_an= $row['flag'];
            if($dap_an !=$bieu_thuc){
                $flag=0;
                break;
            }

        }
        echo "<br>Flag: ".$flag;
        
    ?>
</body>
</html>