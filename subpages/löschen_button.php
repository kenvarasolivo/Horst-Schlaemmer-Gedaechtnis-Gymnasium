<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/login_helper.php";
check_authentication();

$subject_topic_id = isset($_GET['subject_topic_id']) ? intval($_GET['subject_topic_id']) : null;
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

// Fehler anzeigen, wenn keine relevanten Parameter vorhanden sind
if (is_null($subject_topic_id) && is_null($subject_id)) {
    die("Weder 'subject_topic_id' noch 'subject_id' ist gesetzt.");
}

$current_page = basename($_SERVER['PHP_SELF']);

?>
<style>
    #button {
        position: absolute;
        left: 2vw;
        bottom: 20px;
        cursor: pointer;
        background-color: #ff0000;
        color: #ffffff;
        padding: 1.5vh 3vw;
        border-radius: 12px;
        text-decoration: none;
        font-size: 3vh;
        font-weight: bold;
        display: inline-block;
        transition: background-color 0.3s ease;
        border: none;
    }

    #button:hover {
        background-color: #ffffff;
        color: #ff0000;
    }
</style>

<div>
    <?php if (is_teacher()): ?>
        <?php if ($current_page === 'subject_topic.php'): ?>
            <a href="../delete_function.php?subject_topic_id=<?php echo urldecode($subject_topic_id); ?>"
               onclick="return confirm('Sind Sie sicher, dass Sie dieses Subject löschen möchten?');">
                <button id="button">Seite Löschen</button>
            </a>
        <?php elseif ($current_page === 'topics.php'): ?>

            <a href="../delete_function.php?subject_id=<?php echo urldecode($subject_id); ?>"
               onclick="return confirm('Sind Sie sicher, dass Sie dieses Topic löschen möchten?');">
                <button id="button">Thema löschen</button>
            </a>
        <?php endif; ?>
    <?php endif; ?>
</div>

