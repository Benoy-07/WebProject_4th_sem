<?php
include('../includes/db.php');
session_start();

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    $userEmail = $_SESSION['user'];
    $fileTmp = $_FILES['avatar']['tmp_name'];
    $fileName = uniqid() . "_" . basename($_FILES['avatar']['name']);
    $targetPath = "../uploads/" . $fileName;

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if (move_uploaded_file($fileTmp, $targetPath)) {
            // Update DB
            $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE email = ?");
            $stmt->bind_param("ss", $fileName, $userEmail);
            if ($stmt->execute()) {
                $_SESSION['avatar'] = $fileName;
                header("Location: profile.php?success=1");
                exit;
            }
        } else {
            echo "Failed to move file.";
        }
    } else {
        echo "Invalid file type.";
    }
} else {
    echo "Upload failed.";
}
?>
