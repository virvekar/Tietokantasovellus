
<h1>Puuhan muokkaus</h1>
<form class="form-horizontal" role="form" action="puuhanMuokkausK.php?puuhanid=<?php echo $data->uusiPuuha->getId(); ?>" method="POST">
    <div class="form-group">
        <label for="nimi" class="col-md-2 control-label">Puuhan nimi</label>
        <div class="col-md-10">
            <input type="text" class="form-control" value="<?php echo $data->uusiPuuha->getNimi() ?>" id="nimi" name="nimi" >
        </div>
    </div>
                <div class="col-md-offset-1">
                Puuha-luokka: 
            </div>
            <div class="col-md-offset-1"> 
                <div class="form-group">
                    <select name="luokkasailio" id="luokkasailio">
                        <option value="0" selected>-</option>
                        <option value="any">Mikä tahansa</option>
                        <?php
                        if (isset($data->luokat)) {

                            foreach ($data->luokat as $puuhaluokka):
                                ?>
                                <option value="<?php echo $puuhaluokka->getId();?>"><?php echo $puuhaluokka->getNimi(); ?></option>
                                <?php
                            endforeach;
                        }
                        ?>

                    </select></div>
            </div>
            <div class="col-md-offset-1 col-md-5"> 
                <div class="form-group">

                    <input value="<?php echo htmlspecialchars($data->uusiPuuha->getPuuhaluokanNimi()); ?>" type="text" class="form-control" id="luokka" name="luokka" placeholder="Valitse luokka valikosta tai kirjoita se tähän" >

                </div>
            </div>
<br>
<br>
<br>
<br>
    <div class="form-group">
        <label for="kuvaus" class="col-md-2 control-label">Kuvaus</label>
        <div class="col-md-10">
            <input type="text" value="<?php echo htmlspecialchars($data->uusiPuuha->getKuvaus()); ?>" style="height: 200px; width: 300px" class="form-control" id="kuvaus" name="kuvaus" >
        </div>
    </div>
    <div class="form-group">
        <label for="kesto" class="col-md-2 control-label">Kesto tunteina</label>
        <div class="col-md-10">
            <input type="text" value="<?php echo htmlspecialchars($data->uusiPuuha->getKesto()); ?>" class="form-control" id="kesto" name="kesto" >
        </div>
    </div>
    <div class="form-group">
        <label for="henkilomaara" class="col-md-2 control-label">Henkilömäärä</label>
        <div class="col-md-10">
            <input type="text" value="<?php echo htmlspecialchars($data->uusiPuuha->getHenkilomaara()); ?>" class="form-control" id="henkilomaara" name="henkilomaara">
        </div>
    </div>
   <div class="col-md-offset-1">
                Paikka: 
   </div>
    <div class="form-group">
        <div class="col-md-3 col-md-offset-1">                 
              <select name="paikkasailio" id="paikkasailio">
                <option value="any" selected="selected">Mikä tahansa</option>
                <option value="kotona">Kotona</option>
                <option value="ulkona">Ulkona</option>
                <option value="julkinen">Julkinen</option>

            </select></div>
</div>
        <div class="col-md-offset-1 col-md-5"> 
                <div class="form-group">

                    <input value="<?php echo htmlspecialchars($data->uusiPuuha->getPaikka()); ?>" type="text" class="form-control" id="paikka" name="paikka" placeholder="Valitse paikan kuvaus valikosta tai kirjoita se tähän" >

                </div>
            </div>
  <br>
<br>
<br>
<br>  
Ajankohdan talletuksessa on vielä jotain vikaa
<div class="form-group">
        <label for="paiva" class="col-md-2 control-label">Päivä</label>
        <div class="col-md-10">
            <input type="text" placeholder="Syötä muodossa 1.1.2014" value="<?php echo htmlspecialchars($data->uusiPuuha->getPaiva()); ?>" class="form-control" id="paiva" name="paiva">
        </div>
    </div>
<div class="form-group">
        <label for="kellonaika" class="col-md-2 control-label">Kellonaika</label>
        <div class="col-md-10">
            <input type="text" placeholder="Syötä muodossa 01.01" value="<?php echo htmlspecialchars($data->uusiPuuha->getKellonaika()); ?>" class="form-control" id="kellonaika" name="kellonaika">
        </div>
    </div>
      <div class="col-md-offset-1">
                Tarvittavat taidot: Taidon liittäminen puuhaan on vielä tekemättä
            </div>
            <div class="col-md-offset-1"> 
                <div class="form-group">
                    <select name="taitosailio" id="taitosailio">
                        <option value="any" selected="selected">Ei erityistaitoja</option>
                        <?php
                        if (isset($data->taidot)) {

                            foreach ($data->taidot as $taito):
                                ?>
                                <option value=<?php echo $taito->getId(); ?>><?php echo $taito->getNimi(); ?></option>
                                <?php
                            endforeach;
                        }
                        ?>

                    </select></div>
            </div>
            <div class="col-md-offset-1 col-md-5"> 
                <div class="form-group">

                    <input type="text" class="form-control" id="taito" name="taito" placeholder="Valitse taitoluokka valikosta tai kirjoita se tähän" >

                </div>
            </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" id=submitpuuha name="submitpuuhaMuokkaus" class="btn btn-default">Tallenna muutokset</button>
        </div>
    </div>
</form>