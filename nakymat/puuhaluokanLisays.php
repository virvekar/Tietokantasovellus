
<div> 
    <h1><?php
        if ($data->tyyppi == "Lisays") {
            ?> Puuhaluokan lisäys
        <?php } else if ($data->tyyppi == "Muokkaus") {
            ?> Puuhaluokan muokkaus
        <?php }
        ?></h1>
    <form class="form-horizontal" role="form" action="
          <?php
    if ($data->tyyppi == "Lisays") {
        echo "puuhaluokanLisaysK.php";
    } else if ($data->tyyppi == "Muokkaus") {
        echo "puuhaluokanMuokkausK.php?puuhaluokanid=" . $data->uusiLuokka->getId();
    }
    ?>" method="POST">
        <div class="form-group">
            <label for="nimi" class="col-md-2 control-label">Luokan nimi</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="nimi" name="nimi" value="<?php echo htmlspecialchars($data->uusiLuokka->getNimi()); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="kuvaus" class="col-md-2 control-label">Kuvaus</label>
            <div class="col-md-10">
                <textarea  type="text" class="form-control" id="kuvaus" name="kuvaus" ><?php echo  htmlspecialchars($data->uusiLuokka->getKuvaus()); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" id=submitluokka name="submitluokka" class="btn btn-default"> <?php
                    if ($data->tyyppi == "Lisays") {
                        ?> Lisää
                    <?php } else if ($data->tyyppi == "Muokkaus") {
                        ?> Muokkaa
                    <?php }
                    ?></button>
            </div>
        </div>
    </form>

</div>

