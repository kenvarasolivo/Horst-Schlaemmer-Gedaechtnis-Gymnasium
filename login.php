<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>HSGG - login</title>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body{
            background-color: white;
            margin-left: 5rem;
            position: absolute;
        }
        .container{
            display: grid;
            grid-template-columns: 40rem 30rem;
            gap: 200px;
            align-items: center;
            margin-top: 50px;
        }
        h1{
            font-size: 50px;
            font-weight: bold;
            font-family: 'Overpass', sans-serif;
            margin-bottom: 40px;
        }

        .login-section label{
            font-family: 'Nunito', sans-serif;
            font-size: 30px;
            display: block;
            margin-bottom: 20px ;
        }
        .login-section input{
            width: 100%;
            border: 2px solid #789ADE;
            border-radius: 80px;
            font-size: 20px;
            padding: 25px;
            margin-bottom: 30px;

        }
        .login-section .input-box{
            position: relative;
        }
        .login-section .input-box #eye i{
            position: absolute;
            right: 0;
            top: 51%;
            width: 20px;
            cursor: pointer;
            font-size: 20px;
        }
        #hidel1{
            display: none;
        }

        .login-section button{
            width: 109%;
            margin-top: 35px;
            border: 2px solid #8699DA;
            background-color: #8699DA;
            border-radius: 80px;
            padding: 25px;
            color: #ffffff;
            cursor: pointer;
            font-size: 20px;
        }

        #loginSuccess{
            color: green;
            font-family: 'Overpass', sans-serif;
            font-size: 18px;
            margin-top: 10px;
        }
        #error-message {
            color: red;
            font-family: 'Overpass', sans-serif;
            font-size: 18px;
            margin-top: 10px;
        }
        
        .smallLogo {
            display: none;
        }

        @media only screen and (max-width: 1500px) {
            body {
                margin-left: 10px;
            }
            .container {
                grid-template-columns: 1fr;
                gap: 0;
                margin-top: 5px;
            }
            .input-box, #username, #loginBtn {
                width: 85%;
            }
            #loginBtn {
                width: calc(85% + 50px);
            }
            .smallLogo {
                width: 100px;
                display: block;
            }
            .smallLogo img {
                width: 100%;
            }
            .bigLogo {
                display: none;
            }
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <div class="Logo smallLogo">
        <img src="image/Logo_A4.png" style="text-align: center;">
    </div>
    <div class="login-section">
        <h1>Willkommen an die Mathematiker des H.S.G.G</h1>

        <form action="#" method="post">
            <label for="username">Benutzernamen</label>
            <input type="text" id="username" name="username" placeholder="Trage deinen Benutzernamen ein" required>

            <div class="input-box">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" placeholder="Passwort welches du von deiner Lehrkraft erhalten hast" required>
                <span id="eye" onclick="togglePassword()">
                        <i id="hidel1" class="fa-solid fa-eye"></i>
                        <i id="hidel2" class="fa-solid fa-eye-slash"></i>
                    </span>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                require_once "connection.php";

                $stmt = $con->prepare("SELECT * FROM user WHERE username=?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if ($row == NULL || count($row) <= 0) {
                    echo '<p id="error-message">Benutzername oder Passwort ist falsch.</p>';
                } else {
                    $dbpassword = $row['password'];
                    if ($dbpassword == $password) {
                        $role = $row['role'];
                        $_SESSION['username'] = $username; // Store the username in session
                        $_SESSION["role"] = $role;
                        $name = $row['firstname'] . " " . $row['lastname'];
                        echo '<p id="loginSuccess">Login erfolgreich! Hallo ' . htmlspecialchars($name) . '.</p>';
                        echo '<script>
                            setTimeout(function() {
                                window.location.href = "main.php";
                            }, 1000);
                        </script>';
                        exit;
                    } else {
                        echo '<p id="error-message">Benutzername oder Passwort ist falsch.</p>';
                    }
                }
            }
            ?>

            <button type="submit" id="loginBtn">Einloggen</button>
        </form>
    </div>
    <div class="Logo bigLogo">
        <img src="image/Logo_A4.png" width="100%" style="text-align: center;">
    </div>
</div>
<script>
    function togglePassword(){
        var x = document.getElementById("password");
        var y = document.getElementById("hidel1");
        var z = document.getElementById("hidel2");

        if(x.type === 'password'){
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
        }else{
            x.type = "password";
            y.style.display = "none";
            z.style.display = "block";
        }
    }
</script>
</body>
</html>
