<h1><?php echo $data->nimi; ?></h1>
<?php if (OnkoYllapitajaKirjautunut()) { ?>
    <a href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/yllapitajanSivuK.php"> Ylläpitäjän sivu</a>
    <br> <?php } ?> 

<?php if (!empty($data->osatutTaidot)) { ?>
    <div> <h2> Osaamani taidot</h2>

        <table style="width:400px" class="table table-striped">
            <thead>
                <tr>
                    <th>Nimi</th>
                    <th>Kuvaus</th>
                    <th>Poista</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data->osatutTaidot)) {

                    foreach ($data->osatutTaidot as $taito):
                        ?>
                        <tr>
                            <td><?php echo $taito->getNimi(); ?></td>
                            <td> <?php echo $taito->getKuvaus(); ?></td>
                            <td>
                                <form action="omaSivuK.php" method="post">
                                    <input type="hidden" name="taito_id" value="<?php echo $taito->getId(); ?>">
                                    <input type="submit" id=submitPoistaOmistaTaidoista name="submitPoistaOmistaTaidoista" value="Poista">
                                </form>
                            </td>

                        </tr>
                        <?php
                    endforeach;
                }
                ?>
        </table>
    </div>
<?php } else { ?>
    <br>Sinulla ei ole vielä taitoja merkattuna osaamiskesi taidoiksi.<br>
<?php }
if (!empty($data->suosikkiPuuhat)) {
    ?>
    <div> <h2> Suosikkipuuhani</h2>
        <table style="width:400px" class="table table-striped">
            <thead>
                <tr>
                    <th>Nimi</th>
                    <th>Kuvaus</th>
                    <th>Poista</th>
                    <th>Kirjoita suositus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data->suosikkiPuuhat)) {

                    foreach ($data->suosikkiPuuhat as $puuha):
                        ?>
                        <tr>
                            <td><a href=puuhanTiedotK.php?puuhanid=<?php echo $puuha->getId(); ?>"><?php echo $puuha->getNimi(); ?></a></td>
                            <td> <?php echo $puuha->getKuvaus(); ?></td>
                            <td>
                                <form action="omaSivuK.php" method="post">
                                    <input type="hidden" name="puuha_id" value="<?php echo $puuha->getId(); ?>">
                                    <input type="submit" id=submitPoistaSuosikeista name="submitPoistaSuosikeista" value="Poista">
                                </form>
                            </td>
                            <td>Kirjoita suositus</td>

                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <br>Sinulla ei ole vielä puuhia suosikeissa.<br>
<?php }
if (!empty($data->omatPuuhat)) {
    ?>
    <div> <h2> Puuhat jotka olen lisännyt järjestelmään</h2>
        <table style="width:500px" class="table table-striped">
            <thead>
                <tr>
                    <th>Nimi</th>
                    <th>Kuvaus</th>
                    <th>Muokkaa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data->omatPuuhat)) {

                    foreach ($data->omatPuuhat as $puuha):
                        ?>
                        <tr>
                            <td><a href=puuhanTiedotK.php?puuhanid=<?php echo $puuha->getId(); ?>"><?php echo $puuha->getNimi(); ?></a></td>
                            <td> <?php echo $puuha->getKuvaus(); ?></td>
                            <td><a href=puuhanMuokkausK.php?puuhanid=<?php echo $puuha->getId(); ?>">Muokkaa</a></td>



                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <br>Et ole lisännyt järjestelmään vielä yhtään puuhaa.<br>
<?php }
if (!empty($data->omatTaidot)) {
    ?>
    <div> <h2> Taidot jotka olen lisännyt järjestelmään</h2>
        <table style="width:500px" class="table table-striped">
            <thead>
                <tr>
                    <th>Nimi</th>
                    <th>Kuvaus</th>
                    <th>Muokkaa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data->omatTaidot)) {

                    foreach ($data->omatTaidot as $taito):
                        ?>
                        <tr>
                            <td><?php echo $taito->getNimi(); ?></td>
                            <td> <?php echo $taito->getKuvaus(); ?></td>
                            <td><a href=taidonMuokkausK.php?taidonid=<?php echo $taito->getId(); ?>">Muokkaa</a></td>

                        </tr>
                        <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <br>Et ole lisännyt järjestelmään vielä yhtään taitoa.<br>
<?php } ?>
<a class="btn" href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/salasananVaihtoK.php">Vaihda salasana</a>
<br>
<br>
 <form action="omaSivuK.php" method="post">
        <input type="submit" id=submitPoistaHenkilo name="submitPoistaHenkilo"  
               onclick="return confirm('Oletko varma että haluat poistua pysyvästi järjestelmästä? Kaikki lisäämäsi sisältö poistetaan?')" 
               value="Jätä puuha-arkisto pysyvästi">
</form>

