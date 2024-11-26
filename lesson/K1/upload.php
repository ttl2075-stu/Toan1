<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['fileToUpload']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($uploadFile)) {
        echo json_encode(['error' => 'File already exists.']);
        $uploadOk = 0;
    }

    // Check file size (you can customize the limit)
    if ($_FILES['fileToUpload']['size'] > 500000) {
        echo json_encode(['error' => 'File is too large.']);
        $uploadOk = 0;
    }

    // Allow certain file formats (you can customize the allowed types)
    if ($imageFileType !== 'png' && $imageFileType !== 'jpg' && $imageFileType !== 'jpeg' && $imageFileType !== 'gif') {
        echo json_encode(['error' => 'Only PNG, JPG, JPEG, GIF files are allowed.']);
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo json_encode(['error' => 'File upload failed.']);
    } else {
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
            echo json_encode(['success' => 'File uploaded successfully.', 'filePath' => $uploadFile]);
        } else {
            echo json_encode(['error' => 'Error uploading file.']);
        }
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
