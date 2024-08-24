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

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $user, $pass);

    $stmt->execute();

    $result = $stmt->get_result();

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

            </style>
        </head>
        <body>
            <div class="message">
                <h1>Login Successful</h1>
            </div>
        </body>
        </html>
        <?php

    } else {
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
                        color: #f00;
                        font-family: Arial, sans-serif;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        position: relative;
                        padding-bottom: 150px; 
                    }
                    .message {
                        text-align: center;
                    }
                    .debug-box {
                        position: fixed;
                        bottom: 0;
                        left: 0;
                        width: 100%;
                        background-color: #000; 
                        color: #f00;
                        border-top: 1px solid #f00;
                        padding: 10px;
                        font-family: monospace;
                        max-height: 250px; 
                        overflow-y: auto;
                        box-sizing: border-box;
                    }
                    .debug-box h2 {
                        margin-top: 0;
                        font-size: 14px; 
                        text-transform: uppercase;
                        border-bottom: 1px solid #f00;
                        padding-bottom: 5px;
                    }
                </style>
            </head>
            <body>
                <div class="message">
                    <h1>Invalid Credentials</h1>
                </div>
                <div class="debug-box">
                    <h2>Debug Panel</h2>
                    <?php
                        // DEBUG CODE HERE
                        
                    ?>
                </div>
            </body>
            </html>
        <?php

    }

    $stmt->close();
}

$conn->close();
?>
