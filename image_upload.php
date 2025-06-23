<?php
// image_upload.php
function uploadImage($file, $uploadDir, $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png']) {
    $message = '';
    $uploadOk = true;
    $logoPath = null;

    // Check for upload errors first
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        $message = "Fehler: Datei ist zu groß. Maximal erlaubte Größe ist " . formatBytes(convertToBytes(ini_get('upload_max_filesize'))) . ".";
        $uploadOk = false;
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $message = "Fehler: Fehler beim Hochladen der Datei.";
        $uploadOk = false;
    }

    // If no error, validate file size
    if ($uploadOk && $file['size'] > convertToBytes(ini_get('upload_max_filesize'))) {
        $message = "Fehler: Datei ist zu groß. Maximal erlaubte Größe ist " . formatBytes(convertToBytes(ini_get('upload_max_filesize'))) . ".";
        $uploadOk = false;
    }

    // If no error, validate file type
    if ($uploadOk && !in_array($file['type'], $allowedTypes)) {
        $message = "Fehler: Ungültiger Dateityp. Erlaubte Typen sind: jpg, jpeg, png.";
        $uploadOk = false;
    }

    // Proceed with file upload
    if ($uploadOk) {
        // Generate a unique file name
        $uploadFile = $uploadDir . uniqid() . "_" . basename($file['name']);

        // Prevent overwriting existing files
        if (file_exists($uploadFile)) {
            $message = "Fehler: Datei existiert bereits.";
            $uploadOk = false;
        }

        // Move the file
        if ($uploadOk && move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $logoPath = $uploadFile;
            $message = "Datei wurde erfolgreich hochgeladen.";
        } else {
            $message = "Fehler: Datei konnte nicht hochgeladen werden.";
        }
    }

    return ['path' => $logoPath, 'message' => $message];
}

/**
 * Convert a size value (e.g., "2M", "512K") to bytes.
 */
function convertToBytes($size) {
    $unit = strtolower(substr($size, -1));
    $bytes = (int) $size;

    switch ($unit) {
        case 'g':
            $bytes *= 1024 * 1024 * 1024;
            break;
        case 'm':
            $bytes *= 1024 * 1024;
            break;
        case 'k':
            $bytes *= 1024;
            break;
    }

    return $bytes;
}

/**
 * Format bytes into a human-readable string (e.g., "2 MB").
 */
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $pow = min(floor(log($bytes, 1024)), count($units) - 1);
    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>