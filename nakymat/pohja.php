<?php
require_once 'tietokanta/kirjastot/onkoKirjautunut.php';
?>
<!DOCTYPE html>

<html>
    <head>


        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">

        <title>Puuha-arkisto</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-3">  
                    <h1>Puuha-arkisto</h1>
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <a href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/kirjautuminen.php">
                        <?php if (OnkoKirjautunut()) { ?>
                            Kirjaudu ulos</a>
                    <?php } else { ?> Kirjaudu sisään</a>
                    <?php } ?> <br>
                    <a href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/rekisteroityminenK.php">Rekisteröidy</a>
                </div>
            </div>
            <?php if (!empty($data->aktiivinen)) { ?>
                <ul class="nav nav-tabs" data-tabs="tabs">
                    <li <?php if ($data->aktiivinen == "haku") { ?>class="active"<?php } ?>><a 
                            href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/hakuK.php" data-toggle="tab">Puuha-haku</a></li>
                    <li <?php if ($data->aktiivinen == "puuhat") { ?>class="active"<?php } ?>><a 
                            href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/puuhatK.php" data-toggle="tab">Puuhat</a></li>
                    <li <?php if ($data->aktiivinen == "taidot") { ?>class="active"<?php } ?>><a 
                            href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/taidotK.php" data-toggle="tab">Taidot</a></li>
                    <li <?php if ($data->aktiivinen == "omaSivu") { ?>class="active"<?php } ?>><a 
                            href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/omaSivuK.php" data-toggle="tab">Oma sivu</a></li>
                </ul>
                <div id="my-tab-content" class="tab-content">
                    <div class="tab-pane active" >
                    </div>
                </div>
                <?php if (!empty($_SESSION['ilmoitus'])): error_log(print_r($_SESSION['ilmoitus'], TRUE));
                    $ilmoitus=$_SESSION['ilmoitus']?>
                        
                     <font color="blue" size="15"><?php echo $ilmoitus; ?></font> 
  
                    <?php
                    // Samalla kun viesti näytetään, se poistetaan istunnosta,
                    // ettei se näkyisi myöhemmin jollain toisella sivulla uudestaan.
                    unset($_SESSION['ilmoitus']);
                endif;
                ?>
            <?php
            }
            require $sivu;
            ?>

        </div>
    </body>
</html>
