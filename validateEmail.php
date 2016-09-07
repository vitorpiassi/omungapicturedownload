<?php
    $value = $_POST['emailU'];
    
    require_once("utils/connection.php");

    $result = mysqli_query($db,"SELECT id FROM artista WHERE email = '".$value."'");
    
    $row = mysqli_fetch_row($result);

    $idArtista = $row[0];

    if(!$idArtista){
		echo 'notexist';
	}
	else{
		$result2 = mysqli_query($db,"SELECT id FROM imagem WHERE fk_imagem_artista = ".$idArtista);

		$row2 = mysqli_fetch_row($result2);
		
		if($row2[0])
			echo('jatem');
		else
			echo('naotem');
	}    
?>