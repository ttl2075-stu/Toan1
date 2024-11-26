<?php
// Kết nối cơ sở dữ liệu và trả về đối tượng PDO
function connectdb()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nckh_2024";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; // Trả về đối tượng PDO để sử dụng ở các nơi khác
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}
// Sử dụng kết nối cơ sở dữ liệu
$conn = connectdb();
?>
