<?php
    $imagem = $_POST['oidimagem'];
    $email = $_POST['email'];
    
    require_once("utils/connection.php");

    $result = mysqli_query($db,"SELECT id FROM artista WHERE email = '".$email."'");
    
    $row = mysqli_fetch_row($result);

    $idArtista = $row[0];

    $sql = "UPDATE imagem SET fk_imagem_artista = ".$idArtista." WHERE id=".$imagem;

	if ($db->query($sql) === TRUE) {
	    echo "true";
	} else {
	    echo "false";
	}
?>