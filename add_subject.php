<?php
require_once 'login_helper.php';
require_once "connection.php";
require_once 'image_upload.php';

if (!is_teacher()) {
    header('Location: /login.php');
    exit();
}

$uploadDir = "uploads/";
$logoPath = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_name = trim($_POST['subject_name']);

    // Check if a file is uploaded
    if (isset($_FILES['uploaded_image']) && $_FILES['uploaded_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Call the image upload function
        $uploadResult = uploadImage($_FILES['uploaded_image'], $uploadDir);

        if ($uploadResult['path']) {
            $logoPath = $uploadResult['path'];
        } else {
            // Specific error message from uploadImage()
            $_SESSION['message'] = $uploadResult['message'];
            header('Location: main.php');
            exit();
        }

    } elseif (!isset($_FILES['uploaded_image']) || $_FILES['uploaded_image']['error'] === UPLOAD_ERR_NO_FILE) {
        // No file uploaded
        $_SESSION['message'] = "Bitte laden Sie ein Bild hoch.";
        header('Location: main.php');
        exit();
    }

    // Validate subject name
    if (empty($subject_name)) {
        $_SESSION['message'] = "Fachname darf nicht leer sein.";
        header('Location: main.php');
        exit();
    }

    // Check for duplicate subject name
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM subject WHERE name = ?");
    $stmt->bind_param('s', $subject_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $stmt->close();

    if ($count > 0) {
        $_SESSION['message'] = "Fehler: Der Fachname '$subject_name' existiert bereits.";
        header('Location: main.php');
        exit();
    }

    // Add subject to the database
    if ($logoPath) {
        $stmt = $con->prepare("INSERT INTO subject (name, logo) VALUES (?, ?)");
        $stmt->bind_param('ss', $subject_name, $logoPath);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Das Fach wurde erfolgreich hinzugefügt.';
        } else {
            $_SESSION['message'] = 'Fehler beim Hinzufügen des Fachs: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Fehler: Ungültiges Logo.";
    }

    $con->close();
    header('Location: main.php');
    exit();
}
?>
