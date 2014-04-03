
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
            if (isset($data->puuhat)){
                $monesko=0;
                foreach($data->puuhat as $puuha): ?>
                <tr>
                    <td><?php echo $monesko+1; ?></td>
                    <td><a href=puuhanTiedotK.php?puuhanid=<?php echo $puuha->getId(); ?>"><?php echo $puuha->getNimi(); ?></a> </td>
                    <td><?php echo $puuha->getKesto(); ?></td>
                    <td><?php echo $puuha->getPuuhanLisaysPaiva(); ?></td>


                </tr>
                <?php 
                $monesko=$monesko+1;
                endforeach; 
            
            }?>

        </tbody>
    </table></div>