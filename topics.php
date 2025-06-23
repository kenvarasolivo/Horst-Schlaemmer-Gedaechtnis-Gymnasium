<?php
require_once "login_helper.php";
require_once "SubjectHelper.php";
include_once 'image_upload.php';

check_authentication();

if (!isset($_GET['subject_id'])) {
    die("Kein Fach ausgewählt.");
}

$subjectId = intval($_GET['subject_id']);
$selectedSubject = getSubjectById($subjectId);
$topics = getTopicsBySubject($subjectId);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($selectedSubject['name']); ?> - Themen</title>
    <link rel="stylesheet" href="includes/headerstyle.css">
    <link rel="stylesheet" href="includes/footerStyle.css">
    <link rel="stylesheet" href="includes/logoutButton.css">
    <link rel="stylesheet" href="includes/backButtonStyle.css">
    <link rel="stylesheet" href="styles.css">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        p {
            color: red;
            font-size: 5vh;
            font-weight: bold;
            padding: 2vh 3vw;
            border-radius: 12px;
            margin-top: 3vh;
            width: auto;
            max-width: 100%;
            text-align: center;
        }

        main a {
            text-decoration: none;
        }

        .add-subject-topic-form {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 250px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .add-subject-topic-form label,
        .color-picker-wrapper label{
            display: block;
            font-size: 0.9rem;
            color: #333;
        }

        .add-subject-topic-form input[type="text"],
        .add-subject-topic-form input[type="file"],
        .color-picker-wrapper input[type="color"]{
            width: 90%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }

        .color-picker-wrapper {
            display: block;
        }

        .add-subject-topic-form button {
            width: 100%;
            padding: 8px;
            background-color: #007BFF;
            color: white;
            font-size: 0.9rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .add-subject-form button:hover {
            background-color: #0056b3;
        }

        .color-picker-wrapper input[type="color"] {
            width: 100%; /* Ensures that the color picker input takes up the full width */
            padding: 0; /* Removes any default padding from the color input */
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        @media only screen and (max-width: 800px) {
            .grid-container {
                grid-template-columns: initial;
                gap: 15px;
                width: 100%;
            }

            .add-subject-form {
                bottom: 10px;
                right: 10px;
                width: 90%;
            }
        }
    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include "includes/header.php"; ?>

<a href="main.php" class="back-button">Zurück</a>

<main>
    <div class="title-container">
        <h1><?php echo htmlspecialchars($selectedSubject['name']) ?></h1>
    </div>
    <div>
        <div class="grid-container">
            <?php if (!empty($topics)): ?>
                <?php foreach ($topics as $topic): ?>
                    <a href="subpages/subject_topic.php?subject_topic_id=<?php echo $topic['id']; ?>"
                       class="grid-item"
                       style="background-image: url('<?php echo htmlspecialchars($topic['logo']); ?>');">
                        <?php echo htmlspecialchars($topic['name']); ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Keine Themen für dieses Fach gefunden.</p>
            <?php endif; ?>
        </div>
    </div>

    </div>

    <?php if (is_teacher()): ?>
        <?php
        $maxUploadSize = convertToBytes(ini_get('upload_max_filesize'));
        ?>
        <div id="message-container" style="font-weight: bold; margin-bottom: 10px;">
            <?php if (isset($_SESSION['message'])): ?>
                <p style="color: <?php echo strpos($_SESSION['message'], 'erfolgreich') !== false ? 'green' : 'red'; ?>;">
                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                </p>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        </div>

        <form method="post" action="add_subject_topic.php" enctype="multipart/form-data" class="add-subject-topic-form" onsubmit="return validateForm()">
            <label for="subject-name">Neues Thema:</label>
            <input type="text" id="subject-name" name="subject_topic_name" placeholder="Themenname" required>

            <label for="file-upload">Bild (max <?php echo formatBytes($maxUploadSize); ?>):</label>
            <input type="file" id="file-upload" name="uploaded_image" accept="image/*" required>

            <div class="color-picker-wrapper">
                <label for="color">Farbe auswählen:</label>
                <input type="color" id="color" name="color" value="#ff0000">
            </div>


            <input type="hidden" name="subject_id" value="<?php echo $subjectId; ?>">

            <button type="submit">Hinzufügen</button>
        </form>
    <?php endif; ?>
    </div>

    <div>
        <?php if($subjectId != 1){
        include 'subpages/löschen_button.php';}?>
    </div>
</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
