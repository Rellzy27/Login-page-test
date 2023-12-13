<?php
    session_start();

    $host = 'localhost';
    $user = 'rellzy';
    $pass = '060307';
    $db = 'user_login';

    $cnn = new mysqli($host,$user,$pass,$db); 
    
    if(!$cnn){
        die('Connection Error : '.mysqli_connect_error());
    }

    if (!isset($_POST['username'], $_POST['pass']) ) {
        exit('Please fill both the username and password fields!');
    }
    
    if ($stmt = $cnn->prepare('SELECT id, password FROM accounts WHERE username = ?')){
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            if ($_POST['pass'] === $password){
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                echo 'You is '. $_SESSION['name'] . '!';
            }else{
                echo 'Incorrect username or password!';
            }
        } else {
            echo 'Incorrect username or password';
        }

        $stmt->close();
    }
?>