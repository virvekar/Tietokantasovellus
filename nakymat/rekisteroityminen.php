<h1>Rekisteröitymiskaavake:</h1>

<form class="form-horizontal" role="form" action="rekisteroityminenK.php" method="POST">
    <div class="form-group">
        <label for="nimi" class="col-md-2 control-label">Nimimerkki</label>
        <div class="col-md-10">
            <input type="text" class="form-control" value="<?php echo $data->uusiHenkilo->getNimimerkki() ?>" 
                   id="nimi" name="nimi" >
        </div>
    </div>
    <div class="form-group">
        <label for="sahkoposti" class="col-md-2 control-label">Sähköposti</label>
        <div class="col-md-10">
            <input type="Email" class="form-control" value="<?php echo $data->uusiHenkilo->getSahkoposti() ?>" 
                   id="sahkoposti" name="sahkoposti" >
        </div>
    </div>
    <div class="form-group">
        <label for="salasana" class="col-md-2 control-label">Salasana</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="salasana" name="salasana" >
        </div>
    </div>
    <div class="form-group">
        <label for="salasana2" class="col-md-2 control-label">Vahvista salasana</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="salasana2" name="salasana2">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" id=submitrekisteroidy name="submitrekisteroidy" class="btn btn-default">Rekisteröidy</button>
        </div>
    </div>
</form>

