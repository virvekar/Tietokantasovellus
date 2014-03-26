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
                    <a href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/html-demo/Rekisteroityminen.html">Rekisteröidy</a>
                </div>
            </div>
            <?php
            require $sivu;
            ?>


        </div>
    </body>
</html>
