<h1>Ylläpitäjän sivu</h1>
<h3>Blokkaa käyttäjä</h3>
 <form class="form-horizontal" role="form" action="" method="POST">
        <div class="form-group">
            <label for="kayttajanNimimerkki" class="col-md-2 control-label">Käyttäjä</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="kaytttajanNimimerkki" name="kayttaja"
                       value="<?php echo $data->kayttaja; ?>">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Blokkaa</button>
            </div>
        </div>
    </form>
<h3>Poista puuha</h3>
<form class="form-horizontal" role="form" action="yllapitajanSivuK.php" method="POST">
        <div class="form-group">
            <label for="poistettavaPuuha" class="col-md-2 control-label">Poistettavan puuhan nimi</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="poistettavaPuuha" name="poistettavaPuuha">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" id=submitPoistaPuuha name="submitPoistaPuuha" class="btn btn-default">Poista puuha</button>
            </div>
        </div>
    </form>
<h3>Poista puuhaluokka</h3>
<form class="form-horizontal" role="form" action="yllapitajanSivuK.php" method="POST">
        <div class="form-group">
            <label for="poistettavaPuuhaluokka" class="col-md-2 control-label">Poistettavan puuhaluokan nimi</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="poistettavaPuuhaluokka" name="poistettavaPuuhaluokka">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" id=submitPoistaPuuhaluokka name="submitPoistaPuuhaluokka" class="btn btn-default">Poista puuhaluokka</button>
            </div>
        </div>
    </form>
<h3>Poista taito</h3>
<form class="form-horizontal" role="form" action="yllapitajanSivuK.php" method="POST">
        <div class="form-group">
            <label for="poistettavaTaito" class="col-md-2 control-label">Poistettavan taidon nimi</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="poistettavaTaito" name="poistettavaTaito">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" id=submitPoistaTaito name="submitPoistaTaito" class="btn btn-default">Poista taito</button>
            </div>
        </div>
    </form>