<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Horst-Schlämmer-Gedächtnis-Gymnasium</title>
    <link rel="stylesheet" href="includes/headerstyle.css">
    <link rel="stylesheet" href="includes/logoutButton.css">
    <link rel="stylesheet" href="includes/backButtonStyle.css">
    <style>


        body {
            margin: 0;
            padding: 0;
        }

        main{
                padding-top: 120px;
                background-image: url("/image/imp.png");
                background-attachment: fixed;
                background-position: center;
                background-size: cover;
                font-family: Arial, sans-serif;
                padding-bottom: 120px;
                min-height: 100vh;

        }

        .back-button{
            position: fixed;
        }


        #Imp {
            position: fixed;
            margin-top: 80px;
            margin-left: 50px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 60px;
            border: 6px solid black;
            border-radius: 10px;
            background-color: rgb(66, 133, 114);
            display: inline-block;
            padding: 20px;
        }

        #impressum {
            position: fixed;
            color: white;
            text-align: left;
            font-style: normal;
            top: 40%;
            margin-left: 35%;
            margin-right: 35%;
            font-size: 25px;
        }

        #info {
            position: fixed;
            display: inline-block;
            top: 60%;
            color: white;
            padding: 10px;
            margin-top: 170px;
            font-size: 20px;
            margin-left: 40px;
            border: 6px solid black;
            border-radius: 10px;
            background-color: rgb(66, 133, 114);
        }

        header,footer{
            position: fixed;
            flex: 1;
        }

    </style>
</head>

<body>

<?php include "includes/header.php"?>
<a href="main.php" class="back-button" onclick="goBack()">Zurück</a>

<main>

<h1 id="Imp">Impressum:</h1>
<div id="impressum">
    <p>Die Inhalte dieser Webseite sind urheberrechtlich geschützt.
        Jegliche Vervielfältigung, Bearbeitung und Verbreitung außerhalb der Grenzen
        des Urheberrechts bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw.
        Erstellers.</p><br>
</div>
<div id="info">
    <p>Horst-Schlämmer-Gedächtnis-Gymnasium<br>
        Schätzeleinstraße 31 <br>
        41515 Grevenbroich
    </p>
</div>
</main>

</body>
<script>
    function goBack(){
        window.history.back();
    }
</script>
</html>
