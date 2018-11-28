<?php
    getIdentity();
    
    $auth = new Auth();
    
    if(isset($this->vars['exist'])){
        $exist = $this->vars['exist'];
    }
    
    if(isset($this->vars['form'])){
        $form = $this->vars['form'];
    }
    
    if(isset($this->vars['sortie'])){
        $sortie = $this->vars['sortie'];
    }
?>

<div class="box">
    <?php
        if($auth->allow('logistique')){
            if(!$_POST){
                echo "<h3>Sortie téléphone</h3>";
                echo $form;
                echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
            }
            elseif(isset($sortie)&&$sortie>0){
                echo "<p>Téléphone déjà sorti</p>";
                echo '<p><a id="ret" href="'.Route::url('index').'">Retour &rarr;</a></p>';
            }
            elseif(isset($exist)&&$exist==0){
                echo "<p>Le téléphone n'est pas en stock</p>";
                echo '<p><a id="ret" href="'.Route::url('tel/ajouter').'">Ajouter modèle &rarr;</a></p>';
                echo '<p><a id="ret" href="'.Route::url('tel/vente').'">Retour &rarr;</a></p>';
            }
            else{
                echo "<p>Sortie OK</p>";
                echo '<a id="ret" href="'.Route::url('tel/vente').'">OK &rarr;</a>'; 
            }
        }else{
            echo '<h3>Vous n\'avez pas accès à cette page</h3>';
            echo '<a href="'.Route::url('index').'">Retour &rarr;</a>';
        }
    ?>
</div>

<script type="text/javascript" src="<?php echo Route::url('js/phonemvt.js'); ?>" > </script>