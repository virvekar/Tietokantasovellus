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
                    <td><?php echo $puuha->getKesto(); ?></td>
                </tr>
                <tr>
                    <td>Henkilömäärä:</td>
                    <td><?php echo $puuha->getHenkilomaara(); ?></td>
                </tr>
                <tr>
                    <td>Tarvittavat taidot:</td>
                    <td>Ei erityistaitoja</td>
                </tr>
                <tr>
                    <td>Suositukset:</td>
                    <td>Ei suosituksia</td>
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
    <?php if (OnkoKirjautunut()){ ?>
        <?php if (!($puuha->OnkoTykannyt($data->kirjautuneenid))) { ?>
            <form action="puuhanTiedotK.php" method="post">
                <input type="hidden" name="puuha_id" value="<?php echo $puuha->getId(); ?>">
                <input type="submit" id=submitLisaaSuosikkeihin name="submitLisaaSuosikkeihin" value="Tykkää">
            </form>
        <?php } ?>
        <a class="btn" href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/suosituksenKirjoitusK.php">Kirjoita Suositus</a>
        <?php
        if(OnkoYllapitajaKirjautunut()){ ?>
            <form action="puuhanTiedotK.php" method="post">
                <input type="hidden" name="puuha_id" value="<?php echo $puuha->getId(); ?>">
                <input type="submit" id=submitPoista name="submitPoista" value="Poista tietokannasta">
            </form>
     <?php   }
    }
    }
    ?>
</div> 


