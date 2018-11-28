<?php
    getIdentity();
    $auth = new Auth();
    
    $form = $this->vars['form'];  
?>

<div class="box">
    <?php
        if($auth->allow('admin')){
            if(!$_POST){
                echo "<h3>Ajouter un utilisateur</h3>";
                echo $form;
                echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
            }else{
                echo "<p>L'utilisateur a bien été ajouté</p>";
                echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
            }
        }else{
            echo '<h3>Vous n\'avez pas accès à cette page</h3>';
            echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
        }
        
        
    ?>
</div>