<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TelController
 *
 * @author DigiHome
 */
class TelController extends Controller{
    // var
    
    // init
    
    // actions
    public function index(){
        $this->redirect('tel/info');
    }
    
    /**
     * Add a new phone model
     */
    public function ajouter(){
        $db = new Db();
        
        if(isPost()){
            
            $models = $db->getRows('select * from models');
            
            if(isUnique($models, getVal('EAN'), 'm_ean')){           
                $insert = array(
                    "m_ean" => getVal('EAN'),
                    "m_gu" => getVal('code Article'),
                    "m_desc" => getVal('modèle')
                );

                $db->insert('models', $insert);
            }else{
                $this->setVars('exist', 1);
                $this->render('ajouter');
            }
            
        }
        
        $form = new Form();
        $form->addOptions(array("id"=>"addphone", "class"=>"", "method"=>"post", "action"=>Route::url('tel/ajouter')));
        $form->addElems(array('EAN'=>'text', 'code Article'=>'text', 'modèle'=>'text', 'ajouter'=>'submit'));
                
        $this->setVars('form', $form->formRender());
    }
    
    /**
     * Take a phone from the stock
     */
    public function sortie() {
        $db = new Db();
        
        $sql = "select idConfig, c_move from config where c_sens = 'sortie'";
        $res = $db->getRows($sql);
        
        if(isPost()){
            
            $stock = $db->getRows('select idStock from stock where s_imei = ?', array(getVal('IMEI')));
            $phoneId = $stock[0]->idStock;
            
            if($phoneId!=NULL){
                
                $mvt = $db->getRows('select Config_idConfig,c_sens from mouvements join config on Config_idConfig = idConfig where Stock_idStock = ?', array($phoneId));
                $move = $mvt[count($mvt)-1]->c_sens;
                debug($move);
                //die();
                
                if($move !=  'sortie'){
                    
                    $insert = array(
                        "mv_user" => $auth->user('u_codeVente'),
                        "mv_date" => date('Y-m-d'),
                        "Config_idConfig" => getVal('motif'),
                        "Stock_idStock" => $phoneId
                    );

                    $db->insert('mouvements', $insert);
                }
                else{
                    $this->setVars('sortie', 1); 
                }
            }
            else{
                $this->setVars('exist', 0);
                $this->render('vente');
            }
        }
        
        $list = array();
        foreach ($res as $v) {
            $list[] = array($v->idConfig=>$v->c_move);
        }
        
        $form = new Form();
        $form->addOptions(array("id"=>"sortiephone", "class"=>"", "method"=>"post", "action"=>Route::url('tel/vente')));
        $form->addElems(array('IMEI'=>'text', 'motif'=>'select', 'OK'=>'submit'));
        $form->addSelOpt($list);
        
        $this->setVars('form', $form->formRender());
    }
    
    /**
     * Add a new phone to the stock
     */
    public function recep() {
        $db = new Db();
        $auth = new Auth;
        
        if(isPost()){
            
            $stock = $db->getRows('select * from stock');
            $model = $db->getRows('select * from models');
            
            // Massy
            if(getVal('motif')==10){
                if(!isReferenced($model, 'm_ean', getVal('EAN'))){
                    $this->setVars('exist', 0);
                    $this->render('recep');
                }
                elseif(isUnique($stock, getVal('IMEI'), 's_imei')){
                    $insert = array(
                        "s_ean" => getVal('EAN'),
                        "s_imei" => getVal('IMEI'),
                        "s_dateAjout" => date('Y-m-d')
                        );

                    $db->insert('stock', $insert);
                }
                else{
                    $this->setVars('exist', 1);
                    $this->render('recep');
                }
            }
            // Other moves
            else{
                if(!isReferenced($model, 'm_ean', getVal('EAN'))){
                    $this->setVars('exist', 0);
                    $this->render('recep');
                }
                else{
                    
                    $phone = $db->getRows('select idStock from stock where s_imei = ?', array(getVal('IMEI')));
                    
                    $phoneId = $phone[0]->idStock;
                    
                    $insert = array(
                        "mv_user" => $auth->user('u_codeVente'),
                        "mv_date" => date('Y-m-d'),
                        "Config_idConfig" => getVal('motif'),
                        "Stock_idStock" => $phoneId
                    );
                    
                    $db->insert('mouvements', $insert);
                }
            }
        }
        
        $sql = "select idConfig, c_move from config where c_sens = 'entree'";
        $res = $db->getRows($sql);
        
        $list = array();
        foreach ($res as $v) {
            $list[] = array($v->idConfig=>$v->c_move);
        }
        
        $form = new Form();
        $form->addOptions(array("id"=>"recepphone", "class"=>"", "method"=>"post", "action"=>Route::url('tel/recep')));
        $form->addElems(array('EAN'=>'text', 'IMEI'=>'text', 'motif'=>'select', 'OK'=>'submit'));
        $form->addSelOpt($list);
        
        $this->setVars('form', $form->formRender());
    }
    
    /**
     * Move a phone to a different stocking area
     */
    public function modemp() {
        $db = new Db();
        $auth = new Auth;
        
        $sql = "select idConfig, c_move from config where c_sens = 'depl'";
        $res = $db->getRows($sql);
        
        if(isPost()){
            
            $stock = $db->getRows('select idStock from stock where s_imei = ?', array(getVal('IMEI')));
            $phoneId = $stock[0]->idStock;
            
            if($phoneId!=NULL){
                
                $mvt = $db->getRows('select Config_idConfig,c_sens from mouvements join config on Config_idConfig = idConfig where Stock_idStock = ?', array($phoneId));
                $move = $mvt[count($mvt)-1]->Config_idConfig;
                debug($move);
                //die();
                
                if($move != getVal('motif')){
                    
                    $insert = array(
                        "mv_user" => $auth->user('u_codeVente'),
                        "mv_date" => date('Y-m-d'),
                        "Config_idConfig" => getVal('motif'),
                        "Stock_idStock" => $phoneId
                    );

                    $db->insert('mouvements', $insert);
                }
                else{
                    //$this->setVars('sortie', 1); 
                }
            }
            else{
                $this->setVars('exist', 0);
                $this->render('vente');
            }
        }
        
        $list = array();
        foreach ($res as $v) {
            $list[] = array($v->idConfig=>$v->c_move);
        }
        
        $form = new Form();
        $form->addOptions(array("id"=>"deplphone", "class"=>"", "method"=>"post", "action"=>Route::url('tel/modemp')));
        $form->addElems(array('IMEI'=>'text', 'motif'=>'select', 'OK'=>'submit'));
        $form->addSelOpt($list);
        
        $this->setVars('form', $form->formRender());
    }
    
    /**
     * Get phone infos and inventory
     */
    public function info() {
        $db = new Db();
        
        $brand = $db->getRows('select idFabricants, f_marque from fabricants');
        $model = $db->getRows('select * from models');
        $status = $db->getRows('select * from config');
        
        $this->setVars('brand', $brand);
        $this->setVars('models', $model);
        $this->setVars('status', $status);
        
        // ajax request treatment
        if($this->isXhr()){
            $case = getVal('case');
            
            switch($case){
                case 0:
                    $history = $db->getHistory();
                    echo buildHistory($history);
                    die();
                    break;
                
                case 1:
                    $history = $db->getHistory(array('where'=>array("idMouvements"=>"IS NULL"),'or'=>array("c_sens"=>"='entree'")));
                    echo buildHistory($history);
                    die();
                    break;

                case 2:
                    $history = $db->getHistory(array('where'=>array("c_move"=>"='reassort rayon'")));
                    echo buildHistory($history);
                    die();
                    break;

                case 3:
                    $brand = getVal('brand');

                    $history = $db->getHistory(array('where'=>array("f_marque"=>"='$brand'")));
                    echo buildHistory($history);
                    die();
                    break;

                case 4:
                    $model = getVal('model');

                    $history = $db->getHistory(array('where'=>array("m_desc"=>"='$model'")));
                    echo buildHistory($history);
                    die();
                    break;

                case 5:
                    $status = getVal('status');
                    $history = $db->getHistory(array('where'=>array("c_move"=>"='$status'")));
                    echo buildHistory($history);
                    die();
                    break;
            }
            
        }
        
        $sql= 'CREATE or replace VIEW `History` AS
            SELECT s.idStock, s.s_ean, s.s_imei, fb.f_marque, md.m_desc, md.m_gu, s.s_user, s.s_dateAjout, mvt.idMouvements, mvt.mv_date, mvt.mv_user, cf.c_move, cf.c_sens  from stock as s
            join fabricants as fb on left(s.s_ean,4) = fb.f_ean
            join models as md on s.s_ean = md.m_ean
            left join mouvements as mvt on s.idStock = mvt.Stock_idStock
            left join config as cf on mvt.Config_idConfig = cf.idConfig
            where mvt.Stock_idStock is null
            or mvt.Stock_idStock = s.idStock
            order by s.idStock ASC';
        
        
        $history = $db->createView($sql);
        $history = $db->getRows('select * from history');
        
        $this->setVars('history', $history);
    }
    
    /**
     * Configure phone options as move nature...
     */
    public function config() {
        // on Todo list...
    }
}
