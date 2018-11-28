<?php
    getIdentity();
    
    $auth = new Auth();

?>

<div class="box">
    <?php
        if($auth->allow('logistique')){
            if(!$_POST){
                echo "<h3>Nouveau modèle</h3>";
                echo $form;
                echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
            }elseif(isset($exist)&&$exist>0){
                echo "<p>Le modèle existe déjà</p>";
                echo '<a href="'.Route::url('tel/ajouter').'">Retour &rarr;</a>';
            }else{
                echo "<p>Modèle ajouté</p>";
                echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
            }
        }else{
            echo '<h3>Vous n\'avez pas accès à cette page</h3>';
            echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
        }
    ?>
</div>