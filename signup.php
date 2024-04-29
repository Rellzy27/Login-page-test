<?php
    session_start();

    $host = 'localhost';
    $user = 'user';
    $pass = 'pass';
    $db = 'user_login';

    $cnn = new mysqli($host,$user,$pass,$db); 
    
    if(!$cnn){
        die('Connection Error : '.mysqli_connect_error());
    }

    if (!isset($_POST['username'], $_POST['pass']) ) {
        exit('Please fill both the username and password fields!');
    }

    if ($stmt = $cnn->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
        $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        
        $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
        $stmt->execute();
        echo 'Your account has been created';
        $stmt->close();
    } else {
        echo 'Could not prepare statement!';

        $cnn->close();
    }

    $cnn->close();
?>
