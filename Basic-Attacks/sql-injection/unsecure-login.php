<?php

$servername = "localhost";
$username = "Nalan";
$password = "Mysql@Nalan";
$dbname = "sql_injection_demo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Vulnerable SQL query
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Login Successful</title>
            <style>
                body {
                    background-color: #333;
                    color: #0f0; 
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .message {
                    text-align: center;
                }
                .debug-box {
                    background-color: #222;
                    color: #0f0;
                    border: 1px solid #0f0;
                    padding: 20px;
                    margin: 0 auto;
                    font-family: monospace;
                    max-height: 300px;
                    overflow-y: auto;
                    text-align: left; 
                    display: inline-block;
                }
            </style>
        </head>
        <body>
            <div class="message">
                <h1>Login Successful</h1>
                
                <div class="debug-box">
                    <?php
                        // DEBUG CODE HERE
                    
                    ?>
                </div>
            </div>
        </body>
        </html>
        <?php

    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Incorrect Credentials</title>
            <style>
            body {
                background-color: #333;
                color: #f00;
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .message {
                text-align: center;
            }
            </style>
        </head>
        <body>
            <div class="message">
                <h1>Incorrect Credentials</h1>
            </div>
        </body>
        </html>
        <?php

    }
}

$conn->close();
?>

