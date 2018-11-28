<?php

class IndexController extends Controller {
    
    /**
     * Loading the menu
     */
    function index(){
        $menu = array(
                'tel'=>array('recep','sortie','modemp','ajouter','info'), 
                'users'=>array('add','supp')
            );
        
		debug($menu, 'menu');  
        $this->setVars('menu', $menu);
    }
}
