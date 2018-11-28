<?php
    getIdentity();
    
    $auth = new Auth();
    
	debug($auth, 'auth');
?>

<div id="main" class="full">
    <ul class="menu">
        <?php
            if(isset($menu)){
                foreach ($menu as $key => $value) {
                   for ($j = 0; $j < count($value); $j++) {

                        if($auth->allow('admin')){
                            echo "<li class='menuItem'><a href='$key/$value[$j]'><span class='item' title='$value[$j] $key'></span></a></li>";
                        }elseif($auth->allow('logistique')){
                            if($value[$j] != 'config' && $value[$j] != 'add' && $value[$j] != 'supp'){
                                echo "<li class='menuItem'><a href='$key/$value[$j]'><span class='item' title='$value[$j] $key'></span></a></li>";
                            }
                        }elseif($auth->allow('vente')){
                            if($value[$j] == 'info'){
                                echo "<li class='menuItem'><a href='$key/$value[$j]'><span class='item' title='$value[$j] $key'></span></a></li>";
                            }
                        }
                    }
                }
            }
        ?>
    </ul>
</div>

<script type="text/javascript" src="js/menu.js"></script>