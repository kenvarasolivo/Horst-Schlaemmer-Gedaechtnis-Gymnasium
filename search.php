<?php
require_once "connection.php";
$searchActive = false;
$searchResults = [];
$search = $_GET['searchword'] ?? NULL;
if ($search != null && trim($search) != '') {
    $searchActive = true;
    $safeInput = mysqli_real_escape_string($con, $search);
    $sql = "SELECT id, name FROM subject_topic WHERE name LIKE '%$safeInput%'";
    $query = mysqli_query($con, $sql);
}

?>

<form role="search" method="GET" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" id="search-form">
    <?php 
    foreach($_GET as $name => $value) {
        if ($name === 'searchword') {
            continue;
        }
    ?>
    <input type="hidden" name="<?php echo htmlspecialchars($name); ?>" value="<?php echo htmlspecialchars($value); ?>">
    <?php } ?>
    <input type="text" id="search" name="searchword" placeholder="Suche nach Aufgaben..." <?php if ($searchActive) { echo "autofocus value='". htmlspecialchars($search) ."'"; } ?>>
    <button type="submit">🔍</button>

    <div id="search-results">
        <?php if ($searchActive && mysqli_num_rows($query) == 0) { ?>
            Leider kein Ergebnis.
        <?php } elseif (!$searchActive) { ?>

        <?php } else { while ($result = mysqli_fetch_assoc($query)) { ?>
            <a href="/subpages/subject_topic.php?subject_topic_id=<?php echo htmlspecialchars($result['id']); ?>"><?php echo $result['name']; ?></a>
            <br>
            <?php
        }
        }
        ?>
    </div>

</form>
