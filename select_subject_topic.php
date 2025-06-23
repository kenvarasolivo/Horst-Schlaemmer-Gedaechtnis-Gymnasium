<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Select Drop-Down für Themen</title>

    <style>


    </style>

</head>

<body>
    <form method="post" action="">
        <label for="select_image">Wähle ein Bild für das Thema der Aufgabe:</label> <br>
        <select id="select_image" name="images1">
            <option value="">Hier Bild auswählen</option>
            <?php
            $directory = 'topic_image';
            $images = glob($directory . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($images as $image) {
                $filename = basename($image);
                $imagename = pathinfo($filename, PATHINFO_FILENAME);
                $selected = (isset($_POST['images1']) && $_POST['images1'] == $image) ? 'selected' : '';
                echo "<option value='$image' $selected>$imagename</option>";
            }
            ?>
        </select>
        <button type="submit">Bestätigen</button>
    </form>
</body>
</html>
