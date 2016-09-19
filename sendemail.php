<?php
    $email = $_POST['email'];
    $image = $_POST['image'];

    $path = 'static/img/'.$image;
    $fileType = mime_content_type( $path );
    $fileName = basename( $path );

    $fp = fopen( $path, "rb" ); // abre o arquivo enviado
    $anexo = fread( $fp, filesize( $path ) ); // calcula o tamanho
    $anexo = chunk_split(base64_encode( $anexo )); // codifica o anexo em base 64
    fclose( $fp ); // fecha o arquivo

    $mensagem .= "Content-Type: ". $fileType ."; name=\"". $fileName . "\"" . PHP_EOL;
    $mensagem .= "Content-Transfer-Encoding: base64" . PHP_EOL;
    $mensagem .= "Content-Disposition: attachment; filename=\"". $fileName . "\"" . PHP_EOL;
    $mensagem .= "$anexo" . PHP_EOL;
    $mensagem .= "--$boundary" . PHP_EOL;

    $headers = "MIME-Version: 1.1\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
    $headers .= "From: roberto.pascoal@omunga.com\r\n"; // remetente
    $headers .= "Return-Path: roberto.pascoal@omunga.com\r\n";
    $envio = mail($email, "Campanha Omunga", $mensagem, $headers);
     
    if($envio)
     echo "Mensagem enviada com sucesso";
    else
     echo "A mensagem não pode ser enviada";
?>