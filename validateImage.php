<?php
    $value = $_POST['oidImage'];
    
    require_once("utils/connection.php");

    $resultimages = mysqli_query($db,"SELECT fk_imagem_artista FROM imagem WHERE id =".$value);
    
    $row = mysqli_fetch_row($resultimages);

    if($row[0] == 0)
        echo 'true';
    else
        echo 'false';
?>