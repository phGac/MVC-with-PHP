<?php

if(!isset($_SESSION['USER'])){
    header('Location: /login');
}

$USER = unserialize($_SESSION['USER']);

?>
<html>
    <body>
        <h1>User</h1>
        id:<?=$USER->getIdUser()?><br/>
        user name:<?=$USER->getUserName()?><br/>
        first name:<?=$USER->getFirstName()?><br/>
        last name:<?=$USER->getLastName()?><br/>
        status:<?=$USER->getUserStatus()?><br/>
        privileges:<?=$USER->getPrivileges()?><br/>
        <br/>
        <input type="submit" onclick="location.href='/logout'" value="Logout" />
    </body>
</html>