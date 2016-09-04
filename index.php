<!DOCTYPE html>
<html>
    <head>
        <title>Campanha Omunga</title>
        <link rel="stylesheet" type="text/css" href="static/css/main.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="logo"></div> 	   
        <div class="explanatory-container">
            <div class="explanatory-text">Texto explicativo</div>
        </div>
        <div class="images-container">
            <?php
                require_once("utils/connection.php");

                $resultimages = mysqli_query($db,"SELECT * FROM imagem");

                while ($row=mysqli_fetch_row($resultimages))
                {
                    echo "
                        <div class='images-list'>
                            <img data-toggle='modal' data-target='#myModal' data-lightbox='image-1' data-title='My caption' class='images' src='static/img/$row[1]_small.jpg'/>
                            <p class='images-autor'>Pintado por $row[3]</p>
                        </div>
                        <div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                          <div class='modal-dialog' role='document'>
                            <div class='modal-content' style='width: 535px;'>
                              <div class='modal-body'>
                                <img class='image-expanded' src='static/img/$row[1]_large.jpg'/>
                                <div class='image-content'></div>
                              </div>
                            </div>
                          </div>
                        </div>
                    ";
                }

            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
