<?php
session_start();
include("connection.php");
$connection = $_POST['connection'];
if(isset($connection)){
    $users = $conn -> query('SELECT * FROM `user`');
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    while($user = $users -> fetch()){
        if($user['email'] == $email && $user['passwd'] == sha1($passwd)){
            $cmd = "/usr/local/bin/python3 main.py ".$user['email'];
            $path = escapeshellcmd($cmd);
            $output = shell_exec($path);
            if(strlen($output) <= 3){
                $_SESSION['attempt'] = $output;
                header('Location: http://localhost:8888/INFO824-CacheRedis/public_html/EtuServices/accueil.php');
            } else{
                echo $output;
            }
        }
    }
}
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RedicCache</title>
    </head>
    <body>
        <h1>Welcome !</h1>
        <form action='' method="POST">
            <input type='text' name='email' placeholder='Mail'/>
            <input type='password' name='passwd' placeholder='Password'/>
            <button type='submit' name='connection'>Se Connecter</button>
        </form>
    </body>
</html>