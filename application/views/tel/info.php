<?php
    getIdentity();
    
    $auth = new Auth();
    
?>

<div class="full">
    
    <div class="sort">
        
        <form id="sortform" class="sort-form" method="post" >
            <table id="sort-options">
                <tr id="togglesearch">
                    <td colspan="2"><a href="<?php echo Route::url('index'); ?>">Retour &rarr;</td>
                </tr>
                <tr>
                    <td><input id="r-all" type="radio" group="case" name="case" value="0" checked="checked" >Tout</td>
                    <td><input id="r-stock" type="radio" group="case" name="case" value="1">Stock</td>
                    <td><input id="r-rayon" type="radio" group="case" name="case" value="2">Rayon</td>
                    <td><input id="r-brand" type="radio" group="case" name="case" value="3">Marque</td>
                    <td><input id="r-model" type="radio" group="case" name="case" value="4">Modèle</td>
                    <td><input id="r-status" type="radio" group="case" name="case" value="5">Etat</td>
                </tr>
                <tr id="search-select">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <select id="brand" name="brand" value="Marque">
                            <optgroup label="Marque">
                                <option value="0">Tous</option>
                            <?php
                                if(isset($brand)){
                                    foreach($brand as $b){
                                        echo '<option value="'.$b->f_marque.'">'.$b->f_marque.'</option>';
                                    }                  
                                }
                            ?>
                            </optgroup>
                        </select>
                    </td>
                    <td>
                        <select id="model" name="model">
                            <optgroup label="Modèle">
                                <option value="0">Tous</option>
                            <?php
                                if(isset($models)){
                                    foreach($models as $m){
                                        echo '<option value="'.$m->m_desc.'">'.$m->m_desc.'</option>';
                                    }
                                }
                            ?>
                            </optgroup>

                        </select>
                    </td>
                    <td>
                        <select id="status" name="status">
                            <optgroup label="Statut">
                                <option value="0">Tous</option>
                            <?php
                                if(isset($status)){
                                    foreach($status as $s){
                                        if($s->idConfig!=10)
                                            echo '<option value="'.$s->c_move.'">'.$s->c_move.'</option>';
                                    }
                                }
                            ?>
                            </optgroup>

                        </select>
                    </td>
                
                    <td colspan="3"><input id="search" type="text" name="search"></td>                    
                </tr>
            </table>
        </form>
        
    </div>
    
    <div class="sort-results">
        
        <table id="history">
            <thead><th>Marque</th><th>Modèle</th><th>Code Article</th><th>IMEI</th><th>Date Mvt</th><th>Utilisateur</th><th>Mouvement</th></thead>
        <?php
        
            if(isset($this->vars['history'])){
                $history = $this->vars['history'];
                //debug($history, 'history');
                foreach($history as $h){

                    echo "<tr>";
                    echo "<td>$h->f_marque</td>";
                    echo "<td>$h->m_desc</td>";
                    echo "<td>$h->m_gu</td>";
                    echo "<td>$h->s_imei</td>";
                    
                    if(!is_null($h->mv_date)){
                        echo "<td>$h->mv_date</td>";
                    }else{
                        echo "<td>$h->s_dateAjout</td>";
                    }
                    
                    if(!is_null($h->mv_user)){
                        echo "<td>$h->mv_user</td>";
                    }else{
                        echo "<td>$h->s_user</td>";
                    }
                    
                    if(!is_null($h->c_move)){
                        echo "<td>$h->c_move</td>";
                    }else{
                        echo "<td>Recep Stock</td>";
                    }
                    echo "</tr>";
                }
            }
        
        ?>
        </table>
    </div>
    
</div>

<script type="text/javascript">

    $(document).ready(function(){
        
        $("#brand").hide();
        $("#model").hide();
        $("#status").hide();
        $("#search").hide();
        
        $("#r-all").click(function(){
            $.post("<?php echo Route::url('tel/info') ?>",
                $(this).serialize(),
                function(data){
                    $("#history").empty();
                    $("#history").append(data);
                },
                "html"
            );
        });
        
        $("#r-stock").click(function(){
            $.post("<?php echo Route::url('tel/info') ?>",
                $(this).serialize(),
                function(data){
                    $("#history").empty();
                    $("#history").append(data);
                },
                "html"
            );
        });
        
        $("#r-rayon").click(function(){
            $.post("<?php echo Route::url('tel/info') ?>",
                $(this).serialize(),
                function(data){
                    $("#history").empty();
                    $("#history").append(data);
                },
                "html"
            );
        });
        
        $("#r-brand").click(function(){
            $("#brand").show();
        });
        
        $("#r-model").click(function(){
            $("#model").show();
        });
        
        $("#r-status").click(function(){
            $("#status").show();
        });
        
        $("#brand").change(function(){
            $.post("<?php echo Route::url('tel/info') ?>",
                $("#sortform").serialize(),
                function(data){
                    $("#history").empty();
                    $("#history").append(data);
                    $("#brand").hide();
                },
                "html"
            );
        });
        
        $("#model").change(function(){
            $.post("<?php echo Route::url('tel/info') ?>",
                $("#sortform").serialize(),
                function(data){
                    $("#history").empty();
                    $("#history").append(data);
                    $("#model").hide();
                },
                "html"
            );
        });
        
        $("#status").change(function(){
            $.post("<?php echo Route::url('tel/info') ?>",
                $("#sortform").serialize(),
                function(data){
                    $("#history").empty();
                    $("#history").append(data);
                    $("#status").hide();
                },
                "html"
            );
        });
        
        
    });

</script>
    