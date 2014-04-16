
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active" id="Taidot">
        <div class="row">
            <div class="col-md-3">  
                <h1>Taidot</h1>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <a class="btn" href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/taidonLisaysK.php">Lisää taito</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Taito</th>
                    <th>Kuvaus</th>
                    <th>Lisäyspäivä</th>
                    <th>Lisääjä</th>
                    <th>Hallitsen!</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data->taidot)) {
                    $monesko = 0;
                    $lisaajat = $data->lisaajaLista;
                    foreach ($data->taidot as $taito):
                        ?>
                        <tr>
                            <td><?php echo ($monesko + 1) + ($data->sivuNumero - 1) * ($data->montakoSivulla); ?></td>
                            <td><?php echo $taito->getNimi(); ?></a> </td>
                            <td><?php echo $taito->getKuvaus(); ?></td>
                            <td><?php echo $taito->getTaidonLisaysPaiva(); ?></td>
                            <td><?php echo $lisaajat[$monesko]; ?></td>
                            <?php if (OnkoKirjautunut()) { ?>
                                <?php if (!($taito->OnkoOmissaTaidoissa($data->kirjautuneenid))) { ?>
                                    <td><form action="taidotK.php" method="post">
                                            <input type="hidden" name="taito_id" value="<?php echo $taito->getId(); ?>">

                                            <input type="submit" id=submitHallitsen name="submitHallitsen" value="Hallitsen!">
                                        </form> </td>

                                <?php }
                            } else {
                                ?>
                                <td>   </td><?php } ?>
                        </tr>
                        <?php
                        $monesko = $monesko + 1;
                    endforeach;
                }
                ?>

            </tbody>
        </table>
        <?php if ($data->sivuNumero > 1): ?>
            <a href="taidotK.php?sivuNumero=<?php echo $data->sivuNumero - 1; ?>">Edellinen sivu</a>
        <?php endif; ?>
        <?php if ($data->sivuNumero < $data->sivuja): ?>
            <a href="taidotK.php?sivuNumero=<?php echo $data->sivuNumero + 1; ?>">Seuraava sivu</a>
<?php endif; ?>

    </div></div>

