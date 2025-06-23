<?php

require_once "connection.php";


function getSubjects() {
    global $con;

    $subjects = [];
    $stmt = $con->prepare("SELECT id, name, logo FROM subject");

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
    } else {
        echo "Fehler beim Abrufen der Fächer: " . $stmt->error;
    }

    $stmt->close();
    return $subjects;
}


function getSubjectById($subjectId) {
    global $con;

    $stmt = $con->prepare("SELECT id, name, logo FROM subject WHERE id = ?");
    $stmt->bind_param("i", $subjectId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    } else {
        echo "Fehler beim Abrufen des Faches: " . $stmt->error;
    }

    $stmt->close();
    return null;
}

function getTopicsBySubject($subjectId) {
    global $con;

    $topics = [];
    $stmt = $con->prepare("SELECT id,logo,name FROM subject_topic WHERE subject_id = ?");
    $stmt->bind_param("i", $subjectId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $topics[] = $row;
        }
    } else {
        echo "Fehler beim Abrufen der Themen: " . $stmt->error;
    }

    $stmt->close();
    return $topics;
}
