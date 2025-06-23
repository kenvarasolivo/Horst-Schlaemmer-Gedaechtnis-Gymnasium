<?php
require_once "../connection.php";

$taskID = isset($_GET["subject_topic_id"])
    ? intval($_GET["subject_topic_id"])
    : 1;

function getSubjectDetails(mysqli $con, int $subjectTopicId)
{
    $default = [
        "name" => "Thema wurde nicht gefunden!",
        "color" => "red",
    ];

    if ($subjectTopicId <= 0) {
        return $default;
    }

    $stmt = $con->prepare("SELECT name, color, subject_id FROM subject_topic WHERE id = ?");
    $stmt->bind_param("i", $subjectTopicId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && ($row = $result->fetch_assoc())) {
        return [
            "name" => $row["name"] ?? $default["name"],
            "color" => $row["color"] ?? $default["color"],
            "subject_id" => $row["subject_id"] ?? $default["subject_id"],
        ];
    }

    return $default;
}

$subjectDetails = getSubjectDetails($con, $taskID);
$subjectName = $subjectDetails["name"];
$subjectColor = $subjectDetails["color"];
$subjectID = $subjectDetails["subject_id"];
$static = false;
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($subjectName); ?></title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../includes/headerstyle.css">
    <link rel="stylesheet" href="../includes/footerStyle.css">
    <link rel="stylesheet" href="../includes/logoutButton.css">
    <link rel="stylesheet" href="../includes/backButtonStyle.css">

    <style>
        
        main {
            margin-top: 0;
        }

        @media (max-width: 800px) {
            main {
                margin-top: 30px !important;
            }
        }

        .subheading {
            background-color: <?php echo htmlspecialchars($subjectColor); ?>;
            color: #ffffff;
            padding: 15px;
            border-radius: 10px;
        }

        #displayArea {
            border-color: <?php echo htmlspecialchars($subjectColor); ?>;
        }

        .download-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .download-button {
            background-color: <?php echo htmlspecialchars($subjectColor); ?>;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .download-button:hover {
            background-color: ;
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .download-text {
            display: block;
            font-size: 14px;
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.8);
        }

    </style>
</head>
<body>

<?php include "../includes/header.php"; ?>

<a href="../topics.php?subject_id=<?php echo $subjectID; ?>" class="back-button">Zurück</a>

<main>
    <div class="content-wrapper">
        <div class="subheading"><?php echo htmlspecialchars($subjectName); ?></div>


        <?php include "plugins/editor_main.php"; ?>
    </div>

    <div class="download-buttons">
        <?php if ($taskID == 1): ?>
               <?php $static = true;?>
            <a href="../subpages/tasks/Addition_und_Subtraktion_grosser_Zahlen.pdf" class="download-button" download>
                Addition und Subtraktion großer Zahlen
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 2): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Multiplikation_und_Division.pdf" class="download-button" download>
                Multiplikation und Division
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 3): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Bruchrechnung_Einfuehrung.pdf" class="download-button" download>
                Bruchrechnung Einführung
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
            <a href="../subpages/tasks/Erweitern_und_Kuetzen_von_Bruechen.pdf" class="download-button" download>
                Erweitern und Kürzen von Brüchen
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 5): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Dezimalsystem_Einfuehrung.pdf" class="download-button" download>
                Dezimalsystem Einführung
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
            <a href="../subpages/tasks/Dezimalzahlen_Runden.pdf" class="download-button" download>
                Dezimalzahlen Runden
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 7): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Prozentrechnung_Einfuehrung.pdf" class="download-button" download>
                Prozentrechnung Einführung
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 8): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Wahrscheinlichkeitsrechnung_Einfuehrung.pdf" class="download-button" download>
                Wahrscheinlichkeitsrechnung Einführung
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 9): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Zinsrechnung.pdf" class="download-button" download>
                Zinsrechnung
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 10): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Graphen_und_Diagramme.pdf" class="download-button" download>
                Graphen und Diagramme
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php elseif ($taskID == 11): ?>
            <?php $static = true;?>
            <a href="../subpages/tasks/Geometrie_Flaecheninhalt_von_Dreiecken.pdf" class="download-button" download>
                Geometrie Flächeninhalt von Dreiecken
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
            <a href="../subpages/tasks/Geometrie_Kreise.pdf" class="download-button" download>
                Geometrie Kreise
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
            <a href="../subpages/tasks/Geometrie_Rechtecke_und_Quadrate.pdf" class="download-button" download>
                Geometrie Rechtecke und Quadrate
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
            <a href="../subpages/tasks/Geometrie_Umfang_von_Figuren.pdf" class="download-button" download>
                Geometrie Umfang von Figuren
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
            <a href="../subpages/tasks/Geometrie_Volumen_von_Quadern.pdf" class="download-button" download>
                Geometrie Volumen von Quadern
                <span class="download-text">Anklicken, um die Aufgabe herunterzuladen</span>
            </a>
        <?php endif; ?>
    </div>

    <div>
        <?php if(!$static && !inEditMode()) {

        include "löschen_button.php";} ?>

    </div>
</main>

<?php include "../includes/footer.php"; ?>

</body>
</html>
