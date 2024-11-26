<?php
$dir = './uploads'; // Đường dẫn đến thư mục chứa ảnh
$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif'); // Các loại phần mở rộng được phép
$files = scandir($dir);

$html = '<div style="display: flex; flex-wrap: wrap;">';

foreach ($files as $index => $file) {
    $path_info = pathinfo($file);

    if (is_file($dir . '/' . $file) && in_array(strtolower($path_info['extension']), $allowed_extensions)) {
        $html .= '<div style="margin: 15px;">';
        $html .= '<img onclick="toggleImageSelection1(\'' . $dir . '/' . $file . '\', ' . $index . ');" id="image-' . $index . '" class="selectable-image" src="' . $dir . '/' . $file . '" data-src="' . $dir . '/' . $file . '" alt="' . $file . '" style="width: 10vh; height: 10vh;" />';
        $html .= '</div>';
    }
}

$html .= '</div>'; // Kết thúc hàng

echo $html;
?>
