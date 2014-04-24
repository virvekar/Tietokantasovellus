<div>
    <?php
    if (isset($data->puuha)) {
        $puuha = $data->puuha;
        ?>
        <table style="width:300px" class="table table-striped">
            <thead>
                <tr>
                    <th>Nimi:</th>
                    <th><?php echo $puuha->getNimi(); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Luokka:</td>
                    <td><?php echo $data->luokanNimi; ?></td>
                </tr>
                <tr>
                    <td>Kuvaus:</td>
                    <td><?php echo $puuha->getKuvaus(); ?></td>
                </tr>
                <tr>
                    <td>Kesto:</td>
                    <td><?php echo number_format((float)$puuha->getKesto(), 2, '.', ''); ?></td>
                </tr>
                <tr>
                    <td>Henkilömäärä:</td>
                    <td><?php echo $puuha->getHenkilomaara(); ?></td>
                </tr>
                <tr>
                    <td>Tarvittavat taidot:</td>
                    <td><?php
                        foreach ($data->taitojenNimet as $taitonimi) {
                            echo $taitonimi;
                            echo "; ";
                        }
                        ?></td>
                </tr>
                <tr>
                    <td>Paikka:</td>
                    <td><?php echo $puuha->getPaikka(); ?></td>
                </tr>
                <tr>
                    <td>Ajankohta:</td>
                    <td><?php echo $puuha->getAjankohta(); ?></td>
                </tr>
                <tr>
                    <td>Lisätty arkistoon:</td>
                    <td><?php echo $puuha->getPuuhanLisaysPaiva(); ?></td>
                </tr>
                <tr>
                    <td>Lisääjä:</td>
                    <td><?php echo $data->lisaaja; ?></td>
                </tr>
            </tbody>
        </table>
        <?php if (OnkoKirjautunut()) { ?>

        <?php if (!($puuha->OnkoTykannyt($data->kirjautuneenid))) { ?>
                <form action="puuhanTiedotK.php" method="post">
                    <input type="hidden" name="puuha_id" value="<?php echo $puuha->getId(); ?>">
                    <input type="submit" id=submitLisaaSuosikkeihin name="submitLisaaSuosikkeihin" value="Tykkää">
                </form>
            <?php } ?>
            <a href=suosituksenKirjoitusK.php?puuhanid=<?php echo $puuha->getId(); ?>">Kirjoita suositus</a> 
        <?php if (OnkoYllapitajaKirjautunut()) { ?>
                <form action="puuhanTiedotK.php" method="post">
                    <input type="hidden" name="puuha_id" value="<?php echo $puuha->getId(); ?>">
                    <input type="submit" id=submitPoista name="submitPoista" value="Poista tietokannasta">
                </form>
                <?php
            }
            ?>
            <br>
            <?php if (OnkoKirjautunutTamaHenkilo($puuha->getLisaaja())) { ?>                       
                <a href="puuhanMuokkausK.php?puuhanid=<?php echo $puuha->getId(); ?>">Muokkaa</a> 
            <?php } ?>

        <?php
        }
    }
    ?>

    <h3>Suositukset</h3>
<?php if (!empty($data->suositukset)) { ?>
        <table style="width:800px" class="table table-striped">
            <thead>
                <tr>
                    <th>Kirjoittaja</th>
                    <th>Suositus</th>
                    <th> </th>
                    <th> </th>

                </tr>
            </thead>
            <tbody>
    <?php foreach ($data->suositukset as $suositus) { ?>
                    <tr>
                        <td><?php echo $suositus->getSuosittelija(); ?></td>
                        <td><?php echo $suositus->getSuositusTeksti(); ?></td>
                        <td> <?php if (OnkoKirjautunutYllapitajaTaiTamaHenkilo($suositus->getPuuhaajaId())) { ?>
                                <form action="puuhanTiedotK.php?puuhanid=<?php echo $puuha->getId(); ?>" method="post">
                                    <input type="hidden" name="suositus_id" value="<?php echo $suositus->getSuositusId(); ?>">
                                    <input type="submit" id=submitPoistaSuositus name="submitPoistaSuositus" value="Poista">
                                </form>
        <?php } ?></td>
                        <td> <?php if (OnkoKirjautunutTamaHenkilo($suositus->getPuuhaajaId())) { ?>

                                <a href="suosituksenMuokkausK.php?suositusid=<?php echo $suositus->getSuositusId(); ?>">Muokkaa suositusta</a> 
                    <?php } ?></td>
                    </tr>
        <?php } ?>
            </tbody>
        </table>	
    <?php } else { ?>
        Puuhalla ei ole suosituksia.
<?php } ?>	    	    
</div> 

