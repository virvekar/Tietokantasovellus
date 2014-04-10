        <h1><?php echo $data->nimi;?></h1>
         <?php if (OnkoYllapitajaKirjautunut()) { ?>
           <a href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/yllapitajanSivuK.php"> Ylläpitäjän sivu</a>
         <br> <?php } ?> 
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
                    <tr>
                        <td>Japanin kieli</td>
                        <td>Osaa sujuvasti japanin kieltä</td>
                        <td><button type="button" class="btn btn-xs btn-default"><span class="glyphicon remove-circle"></span> Poista</button></td>
                    </tr>
                    <tr>
                        <td>Kitaran soitto:</td>
                        <td>Osaa soittaa kitaraa</td>
                        <td><button type="button" class="btn btn-xs btn-default"><span class="glyphicon remove-circle"></span> Poista</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
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
        <a class="btn" href="http://virvemaa.users.cs.helsinki.fi/Tietokantasovellus/salasananVaihtoK.php">Vaihda salasana</a>
   


