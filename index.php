<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Campanha Omunga</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="static/css/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="explanatory-container">
            <div class="logo"></div> 
        </div>      
        <div class="images-container">
            <?php
                require_once("utils/connection.php");

                $resultimages = mysqli_query($db,"SELECT * FROM imagem WHERE fk_imagem_artista = 0");

                while ($row=mysqli_fetch_row($resultimages))
                {
                    echo "
                        <div class='images-list'>
                            <img data-toggle='modal' data-target='#$row[0]' data-lightbox='image-1' data-title='My caption' class='images' src='static/img/$row[1]_small.jpg'/>
                            <p class='images-autor'>$row[3]</p>
                        </div>
                        <div class='modal fade modalPrincipal' id='$row[0]' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                          <div class='modal-dialog' role='document'>
                            <div class='modal-content' style='width: 738px;'>
                              <div class='modal-body'>
                                <img class='image-expanded' src='static/img/$row[1]_large.jpg'/>
                                <div class='image-content'>
                                    <div class='image-description'>
                                        $row[2]
                                    </div>
                                    <div class='email-download form-group'>
                                        <label for='emailinput'>Digite seu e-mail</label>
                                        <input id='emailinput' class='form-control email-input user-email$row[0]' placeholder='omunga@omunga.com'/>
                                        <a class='btn btn-success button-download' onClick='validateImage($row[0], $row[1])'>Download</a>
                                        <a id='download'></a>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    ";
                }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
        <script type='text/javascript'>    
            function validateImage(oid, imagem){
                var me = this;

                $.ajax({
                    url: 'validateImage.php',
                    type: 'POST',
                    data: {
                        oidImage: oid
                    },
                    success:function(response)
                    {   
                        if(response == "true"){
                            me.validateEmail(oid, imagem);
                        }
                        else
                            alert("Esta imagem está indisponível, atualize a página e selecione outra!");
                    }
                })
            }

            function validateEmail(oid, imagem){
                var me = this,
                    email = $('.user-email'+oid).val();
                    
                $.ajax({
                    url: 'validateEmail.php',
                    type: 'POST',
                    data: {
                        emailU: email
                    },
                    success:function(response)
                    {   
                        switch(response) {
                            case 'notexist':
                                alert("Este email não está cadastrado!");
                                break;
                            case 'jatem':
                                alert("Uma imagem já foi escolhida com este e-mail!");
                                break;
                            case 'naotem':
                                me.confirmDownload(oid, imagem, email);
                                break;
                            default:
                                alert("Ocorreu uma falha no servidor, tente novamente mais tarde!");
                        }
                    }
                })
            }

            function confirmDownload(oid, imagem, email){
                var me = this,
                    alert = confirm("Tem certeza que deseja escolher esta foto?");

                if (alert == true) {
                    me.sendEmail();
                    me.downloadImage(oid, imagem, email);
                } else {
                    me.closeModal();
                }                
            }

            function downloadImage(oid, imagem, email){  
               var buttonDownload = $("#download")
                    .attr("href", "/static/img/"+imagem+"_original.jpg")
                    .attr("download", "Omunga.jpg")
                    .appendTo("body");

                buttonDownload[0].click();

                buttonDownload.remove();

                this.setInvalidEmail(oid, email);
            }

            function setInvalidEmail(oidImagem, emailUsuario){
                $.ajax({
                    url: 'setInvalidEmail.php',
                    type: 'POST',
                    data: {
                        email: emailUsuario,
                        oidimagem: oidImagem
                    },
                    success:function(response)
                    {   
                        if(response == "true"){
                            var r = confirm("Caso o download não tenha sido iniciado, foi enviado um email contendo a imagem para você!");
                            if (r == true) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        }
                        else
                            alert("Não foi possível baixar a imagem, tente novamente mais tarde!");
                    }
                })
            }

            function closeModal(){
                $('.modalPrincipal').modal('hide');
            }

            function sendEmail(aux){
                var image = aux + '_large.jpg';
                    
                $.ajax({
                    url: 'sendemail.php',
                    type: 'POST',
                    data: {
                        email: $('.user-email').val(),
                        image: image
                    },
                    success:function(response)
                    {   
                        //if(response == "true"){
                            //me.sendEmail();
                            //me.downloadImage();
                        //}
                        //else
                            //alert("Não foi possível baixar a imagem, atualize a página e tente novamente!");
                    }
                })
            }
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
