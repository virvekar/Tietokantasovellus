<div> 
    <h1>Taidon lisäys </h1>
    <form class="form-horizontal" role="form" action="taidonLisaysK.php" method="POST">
        <div class="form-group">
            <label for="nimi" class="col-md-2 control-label">Taidon nimi</label>
            <div class="col-md-10">
                <input type="text" class="form-control" value="<?php echo $data->uusiTaito->getNimi() ?>" id="nimi" name="nimi" >
            </div>
        </div>

        <div class="form-group">
            <label for="kuvaus" class="col-md-2 control-label">Kuvaus</label>
            <div class="col-md-10">
                 <textarea type="text" style="height: 200px; width: 300px" class="form-control" 
                        id="kuvaus" name="kuvaus" ><?php echo $data->uusiTaito->getKuvaus() ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" id=submittaito name="submittaito" class="btn btn-default">Lisää taito</button>
            </div>
        </div>
    </form>
</div>

