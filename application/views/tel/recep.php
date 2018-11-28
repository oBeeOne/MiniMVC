<?php
    getIdentity();
    
    $auth = new Auth();
    
    if(isset($this->vars['exist'])){
        $exist = $this->vars['exist'];
    }
    
    if(isset($this->vars['form'])){
        $form = $this->vars['form'];
    }
?>

<div class="box">
    <?php
        if($auth->allow('logistique')){
            if(!$_POST){
                echo "<h3>Réception téléphone</h3>";
                echo $form;
                echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
            }
            elseif(isset($exist)&&$exist>0){
                echo "<p>Le téléphone existe déjà</p>";
                echo '<a id="ret" href="'.Route::url('tel/recep').'">Ok &rarr;</a>';
            }
            elseif(isset($exist)&&$exist==0){
                echo "<p>Modèle non référencé</p>";
                echo '<p><a id="ret" href="'.Route::url('tel/ajouter').'">Ajouter modèle &rarr;</a></p>';
                echo '<p><a id="ret" href="'.Route::url('tel/recep').'">Retour &rarr;</a></p>';
            }
            else{
                echo "<p>Réception OK</p>";
                echo '<a id="ret" href="'.Route::url('tel/recep').'">OK &rarr;</a>'; 
            }
        }else{
            echo '<h3>Vous n\'avez pas accès à cette page</h3>';
            echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
        }
    ?>
</div>

<script type="text/javascript" src="<?php echo Route::url('js/phonemvt.js'); ?>" > </script>