
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nimi</th>
                <th>Kesto tunteina</th>
                <th>Lisäyspäivä</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($data->puuhat)) {
                $monesko = 0;
                foreach ($data->puuhat as $puuha):
                    ?>
                    <tr>
                        <td><?php echo ($monesko + 1)+($data->sivuNumero-1)*($data->montakoSivulla); ?></td>
                        <td><a href=puuhanTiedotK.php?puuhanid=<?php echo $puuha->getId(); ?>"><?php echo $puuha->getNimi(); ?></a> </td>
                        <td><?php echo $puuha->getKesto(); ?></td>
                        <td><?php echo $puuha->getPuuhanLisaysPaiva(); ?></td>


                    </tr>
                    <?php
                    $monesko = $monesko + 1;
                endforeach;
            }
            ?>

        </tbody>
    </table>
    <?php if ($data->sivuNumero > 1): ?>
        <a href="luokanPuuhatK.php?sivuNumero=<?php echo $data->sivuNumero - 1; ?>&luokanid=<?php echo $data->luokanid; ?>">Edellinen sivu</a>
    <?php endif; ?>
    <?php if ($data->sivuNumero < $data->sivuja): ?>
        <a href="luokanPuuhatK.php?sivuNumero=<?php echo $data->sivuNumero + 1; ?>&luokanid=<?php echo $data->luokanid; ?>">Seuraava sivu</a>
<?php endif; ?>
</div>