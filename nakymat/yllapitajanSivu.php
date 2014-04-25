<h1>Ylläpitäjän sivu</h1>
<h3>Etsi ja poista vanhentuneet puuhat</h3>
<form class="form-horizontal" role="form" action="yllapitajanSivuK.php" method="POST">
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" id=submitPoistaVanhat name="submitPoistaVanhat" class="btn btn-default">Poista vanhat</button>
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
<h3>Lista käyttäjistä</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nimimerkki</th>
            <th>Asema</th>
            <th>Liittymispäivä</th>
            <th>blokkaa</th>
            <th>korota</th>
            <th>poista</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($data->henkilot)) {
            foreach ($data->henkilot as $henkilo):
                ?>
                <tr>
                    <td><?php echo $henkilo->getNimimerkki(); ?></td>
                    <td><?php echo $henkilo->getAsema(); ?></td>
                    <td><?php echo $henkilo->getLiittymispaiva(); ?> </td>
                    <?php if (!(Henkilo::OnkoYllapitaja($henkilo->getId()))) { ?>                       
                        <td><?php if (!(Henkilo::OnkoBlokattu($henkilo->getId()))) { ?>
                                <form action="yllapitajanSivuK.php" method="post">
                                    <input type="hidden" name="henkilo_id" value="<?php echo $henkilo->getId(); ?>">
                                    <input type="submit" id=submitBlokkaa name="submitBlokkaa" value="Blokkaa">
                                </form>  
                            <?php } else { ?>              
                                <form action="yllapitajanSivuK.php" method="post">
                                    <input type="hidden" name="henkilo_id" value="<?php echo $henkilo->getId(); ?>">
                                    <input type="submit" id=submitPoistaBlokkaus name="submitPoistaBlokkaus" value="Poista Blokkaus">
                                </form>
                            <?php } ?>
                        </td>

                        <td>  <form action="yllapitajanSivuK.php" method="post">                      
                                <input type="hidden" name="henkilo_id" value="<?php echo $henkilo->getId(); ?>">
                                <input type="submit" id=submitKorota name="submitKorota" value="Korota ylläpitäjäksi">
                            </form> </td>

                        <td><form action="yllapitajanSivuK.php" method="post">
                                <input type="hidden" name="henkilo_id" value="<?php echo $henkilo->getId(); ?>">
                                <input type="submit" id=submitPoista name="submitPoista" value="Poista">
                            </form> </td>
                    <?php } ?>
                </tr>
                <?php
            endforeach;
        }
        ?>

    </tbody>
</table>