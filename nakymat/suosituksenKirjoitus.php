<h3><?php echo  $data->puuha->getNimi(); ?></h3>

<form class="form-horizontal" role="form" action=" 
    <?php if($data->tyyppi=="Lisays"){
        echo "suosituksenKirjoitusK.php";  
    } else if ($data->tyyppi=="Muokkaus"){
        echo "suosituksenMuokkausK.php";
    }?>
      " method="POST">
    
<div class="form-group">
    <label for="suosittelu" class="col-md-2 control-label">Suosittelu</label>
    <div class="col-md-10">
        <textarea type="text" style="height: 200px; width: 300px" class="form-control" id="suosittelu" name="suosittelu" ><?php echo  $data->suositus->getSuositusTeksti(); ?></textarea>
    </div>
</div>
<div class="form-group">
 <input type="hidden" name="puuha_id" value="<?php echo  $data->puuha->getId(); ?>">
 <input type="hidden" name="suositus_id" value="<?php echo  $data->suositus->getSuositusId(); ?>">
 </div>
<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        <button type="submit" id=submitLisaaSuositus name="submitLisaaSuositus" class="btn btn-default">Lisää suositus</button>
    </div>
</div>
 </form>