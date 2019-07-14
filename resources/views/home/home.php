<?php

if(!isset($_SESSION['USER'])){
    header('Location: /login');
    exit();
}

$USER = unserialize($_SESSION['USER']);

?>
<html>
    <?php require(_LAYOUTS.'head.php');?>
    <body>
        <h1>User</h1>
        id:<?=$USER->idUser?><br/>
        user name:<?=$USER->userName?><br/>
        first name:<?=$USER->firstName?><br/>
        last name:<?=$USER->lastName?><br/>
        status:<?=$USER->userStatus?><br/>
        privileges:<?=$USER->privileges?><br/>
        error:<?=$USER->money?><br/>
        <br/>
        <input type="submit" onclick="location.href='/logout'" value="Logout" />
    </body>
</html>