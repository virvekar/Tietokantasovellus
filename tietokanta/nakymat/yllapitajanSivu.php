<h1>Ylläpitäjän sivu</h1>

 <form class="form-horizontal" role="form" action="" method="POST">
        <div class="form-group">
            <label for="kayttajanNimimerkki" class="col-md-2 control-label">Käytttäjä</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="kaytttajanNimimerkki" name="kayttaja" 
                       value="<?php echo $data->kayttaja; ?>">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Hae</button>
            </div>
        </div>
    </form>
