<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active" id="puuhat">
        <div class="row">
            <div class="col-md-3">  
                <h1>Puuhat</h1>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <a class="btn" href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/puuhanLisaysK.php">Lisää puuha</a>

            </div>
            <div class="col-md-3 col-md-offset-1">
                <a class="btn" href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/puuhaluokanLisaysK.php">Lisää puuhaluokka</a>

            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Puuhaluokka</th>
                    <th>Kuvaus</th>
                    <th>Luokassa puuhia</th>
                    <th>Viimeisin lisäys</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($data->luokat)){
                $monesko=0;
                $sarakeMontako=$data->sarakeMontako;
                $sarakePaiva=$data->sarakePaiva;
                foreach($data->luokat as $puuhaluokka): ?>
                <tr>
                    <td><?php echo $monesko+1; ?></td>
                    <td><a href=luokanPuuhatK.php?luokanid=<?php echo $puuhaluokka->getId(); ?>"><?php echo $puuhaluokka->getNimi(); ?></a> </td>
                    <td><?php echo $puuhaluokka->getKuvaus(); ?></td>
                    <td><?php echo $sarakeMontako[$monesko]; ?></td>
                    <td><?php echo $sarakePaiva[$monesko]; ?></td>

                </tr>
                <?php 
                $monesko=$monesko+1;
                endforeach; 
                }?>
            </tbody>
        </table>


    </div></div>
