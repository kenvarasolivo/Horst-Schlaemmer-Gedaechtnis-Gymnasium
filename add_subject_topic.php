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
    $subject_topic_name = trim($_POST['subject_topic_name']);
    $subject_id = isset($_POST['subject_id']) ? intval($_POST['subject_id']) : null;

    // Farbe getten
    $color = trim($_POST['color']);


    // Validate subject ID
    if (!$subject_id) {
        $_SESSION['message'] = "Fehler: Das zugehörige Fach wurde nicht angegeben.";
        header('Location: topics.php?subject_id=' . $subject_id);
        exit();
    }

    // Handle file upload
    if (isset($_FILES['uploaded_image']) && $_FILES['uploaded_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = uploadImage($_FILES['uploaded_image'], $uploadDir);

        if ($uploadResult['path']) {
            $logoPath = $uploadResult['path'];
        } else {
            // Specific error message from uploadImage()
            $_SESSION['message'] = $uploadResult['message'];
            header('Location: topics.php?subject_id=' . $subject_id);
            exit();
        }
    } else {
        $_SESSION['message'] = "Bitte laden Sie ein Bild hoch.";
        header('Location: topics.php?subject_id=' . $subject_id);
        exit();
    }

    // ob Farbcode gueltig
    if (!preg_match('/^#[a-fA-F0-9]{6}$/', $color)) {
        $_SESSION['message'] = "Ungültiger Farbcode.";
        header('Location: topics.php?subject_id=' . $subject_id);
        exit();
    }

    // Validate topic name
    if (empty($subject_topic_name)) {
        $_SESSION['message'] = "Der Themenname darf nicht leer sein.";
        header('Location: topics.php?subject_id=' . $subject_id);
        exit();
    }

    // Check for duplicate topic name in the database
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM subject_topic WHERE name = ? AND subject_id = ?");
    $stmt->bind_param('si', $subject_topic_name, $subject_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $stmt->close();

    if ($count > 0) {
        $_SESSION['message'] = "Fehler: Das Thema '$subject_topic_name' existiert bereits für dieses Fach.";
        header('Location: topics.php?subject_id=' . $subject_id);
        exit();
    }

    // Insert into the database if validations pass
    if ($subject_topic_name && $logoPath && $subject_id) {
        $stmt = $con->prepare("INSERT INTO subject_topic (name, logo, subject_id, color) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssis', $subject_topic_name, $logoPath, $subject_id, $color);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Das Thema wurde erfolgreich hinzugefügt.';
        } else {
            $_SESSION['message'] = 'Fehler beim Hinzufügen des Themas: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Fehler: Ungültige Eingabedaten.";
    }

    $con->close();
    header('Location: topics.php?subject_id=' . $subject_id);
    exit();
}
?>
