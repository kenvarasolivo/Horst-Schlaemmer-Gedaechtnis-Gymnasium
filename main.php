<?php
require_once "login_helper.php";
require_once "SubjectHelper.php";
include_once 'image_upload.php';

check_authentication();
$subjects = getSubjects();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Horst-Schlämmer-Gedächtnis-Gymnasium</title>
    <link rel="stylesheet" href="includes/headerstyle.css">
    <link rel="stylesheet" href="includes/footerStyle.css">
    <link rel="stylesheet" href="includes/logoutButton.css">
    <link rel="stylesheet" href="styles.css">

    <style>
        main a {
            text-decoration: none;
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


        .add-subject-form {
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

        .add-subject-form label {
            font-size: 0.9rem;
            color: #333;
        }

        .add-subject-form input[type="text"],
        .add-subject-form input[type="file"] {
            width: 90%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }

        .add-subject-form button {
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

<?php include "includes/header.php" ?>

<main>
    <div class="title-container">
        <h1>Fächer</h1>
    </div>
    <div>
        <div class="grid-container">
            <?php foreach ($subjects as $subject): ?>
                <a href="topics.php?subject_id=<?php echo $subject['id']; ?>"
                   class="grid-item"
                   style="background-image: url('<?php echo htmlspecialchars($subject['logo']); ?>');">
                    <?php echo htmlspecialchars($subject['name']); ?>
                </a>
            <?php endforeach; ?>
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

            <form method="post" action="add_subject.php" enctype="multipart/form-data" class="add-subject-form">
                <label for="subject-name">Neues Fach:</label>
                <input type="text" id="subject-name" name="subject_name" placeholder="Fachname" required>

                <label for="file-upload">Bild (max <?php echo formatBytes($maxUploadSize); ?>):</label>
                <input type="file" id="file-upload" name="uploaded_image" accept="image/*" required>

                <button type="submit">Hinzufügen</button>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php include "includes/footer.php" ?>

</body>
</html>
