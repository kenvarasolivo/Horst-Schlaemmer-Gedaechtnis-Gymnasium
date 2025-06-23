<?php

global $con;
require_once "connection.php";

if (isset($_GET['subject_id'])) {
    // Extract subject_id from the URL
    $subject_id = intval($_GET['subject_id']);

    // Delete dependent entries from subject_topic
    $sql_delete_related = "DELETE FROM subject_topic WHERE subject_id = ?";
    $stmt_delete_related = $con->prepare($sql_delete_related);
    $stmt_delete_related->bind_param("i", $subject_id);

    if (!$stmt_delete_related->execute()) {
        echo "Fehler beim Löschen abhängiger Einträge in subject_topic: " . $stmt_delete_related->error;
        exit;
    }
    $stmt_delete_related->close();

    // Delete the main subject record
    $sql_delete_subject = "DELETE FROM subject WHERE id = ?";
    $stmt_delete_subject = $con->prepare($sql_delete_subject);
    $stmt_delete_subject->bind_param("i", $subject_id);

    if ($stmt_delete_subject->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Fehler beim Löschen des Fachs: " . $stmt_delete_subject->error;
    }
    $stmt_delete_subject->close();

} elseif (isset($_GET['subject_topic_id'])) {
    // Extract subject_topic_id from the URL
    $subject_topic_id = intval($_GET['subject_topic_id']);

    // Delete the main subject_topic record
    $sql_delete_topic = "DELETE FROM subject_topic WHERE id = ?";
    $stmt_delete_topic = $con->prepare($sql_delete_topic);
    $stmt_delete_topic->bind_param("i", $subject_topic_id);

    if ($stmt_delete_topic->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Fehler beim Löschen des Themas: " . $stmt_delete_topic->error;
    }
    $stmt_delete_topic->close();

} else {
    echo "Keine ID angegeben.";
}

// Close the connection
$con->close();

?>
