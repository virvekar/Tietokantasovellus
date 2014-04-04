<?php
 if (!empty($data->virhe)): ?>
  <div class="alert alert-danger"><?php 
  if(is_array($data->virhe)){
      foreach ($data->virhe as $virhelause):
          echo $virhelause;
      endforeach;
  }else{
      echo $data->virhe; 
  }
  ?></div>
<?php endif; ?>


