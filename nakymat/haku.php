
<div id="my-tab-content" class="tab-content">
    <div class="tab-pane active" id="haku">
        <h1>Puuha-haku</h1>
        <form class="form-horizontal" role="form" action="hakuK.php" method="POST">
            <div class="col-md-offset-1">
                Puuha-luokka: 
            </div>
            <div class="col-md-offset-1"> 
                <div class="form-group">
                    <select name="luokkasailio" id="luokkasailio">
                        <option value="0" selected>-</option>
                        <option value="any">Mikä tahansa</option>
                        <?php
                        if (isset($data->luokat)) {

                            foreach ($data->luokat as $puuhaluokka):
                                ?>
                                <option value=<?php echo $puuhaluokka->getId(); ?>><?php echo $puuhaluokka->getNimi(); ?></option>
                                <?php
                            endforeach;
                        }
                        ?>

                    </select></div>
            </div>
            <div class="col-md-offset-1 col-md-5"> 
                <div class="form-group">

                    <input type="text" class="form-control" id="luokka" name="luokka" placeholder="Valitse luokka valikosta tai kirjoita se tähän" >

                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="form-group">
                <div class="col-md-offset-1">
                    Kesto:   
                </div>
                <div class="col-md-offset-1">

                    <select name="Kesto" id="Kesto">
                        <option value="10" selected="selected">Mikä tahansa</option>
                        <option value="1">alle 5 min</option>
                        <option value="2">5-15 min</option>
                        <option value="3">15-30 min</option>
                        <option value="4">30 min - 1 h</option>
                        <option value="5">1 h - 2 h</option>
                        <option value="6">2 h - 5 h</option>
                        <option value="7">5 h - 12 h</option>
                        <option value="8">12 h - 1 vrk</option>
                        <option value="9">yli 1 vrk</option>
                    </select> <br>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-1">
                    Henkilomäärä: 
                </div>
                <div class="col-md-offset-1">
                    <select name="Henkilomaara" id="Henkilomaara">
                        <option value="10" selected="selected">Mikä tahansa</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3-5</option>
                        <option value="4">5-10</option>
                        <option value="5">yli 10</option>
                    </select> <br>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-1 ">
                    Paikka:
                </div>
                <div class="col-md-offset-1">
                    <select name="Paikka" id="Paikka">
                        <option value="any" selected="selected">Mikä tahansa</option>
                        <option value="kotona">Kotona</option>
                        <option value="ulkona">Ulkona</option>
                        <option value="julkinen">Julkinen</option>
                    </select> <br>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-1">
                    <button type="submit" class="btn btn-default">Hae</button>
                </div>
            </div>

        </form> 
        <?php if (isset($data->puuhat)) { ?>
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
                        $monesko = 0;
                        foreach ($data->puuhat as $puuha):
                            ?>
                            <tr>
                                <td><?php echo ($monesko + 1); ?></td>
                                <td><a href=puuhanTiedotK.php?puuhanid=<?php echo $puuha->getId(); ?>"><?php echo $puuha->getNimi(); ?></a> </td>
                                <td><?php echo $puuha->getKesto(); ?></td>
                                <td><?php echo $puuha->getPuuhanLisaysPaiva(); ?></td>


                            </tr>
                            <?php
                            $monesko = $monesko + 1;
                        endforeach;
                    
                    ?>

                </tbody>
            </table>
            
        </div>
        <?php } ?>
    </div>
</div>

