<?php
    $mysql = new mysqli('localhost', 'root', '', 'banco');
    $mysql->set_charset('utf8');

    if($mysql != TRUE) {
        echo "Deu ruim no banco de dados";        
    } 
?>