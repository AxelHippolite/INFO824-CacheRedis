<?php
session_start();
$remains = 10 - intval($_SESSION['attempt']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RedisCache</title>
    </head>
    <body>
        <h1>Bienvenue !</h1>
        <h2>Tentatives de Connexion Restantes : <?php echo $remains?></h2>
    </body>
</html>