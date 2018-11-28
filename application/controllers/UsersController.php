<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author DigiHome
 */
class UsersController extends Controller {

    public function index() {
        $this->redirect('index');
    }
    
    /**
     * Adding user
     */
    public function add() {
        $db = new Db();
        
        if($_POST){
            $datas = $_POST;
            //debug($datas);
            
            $params = array(
                    'u_nom'         =>  htmlentities($datas['nom']),
                    'u_prenom'      =>  htmlentities($datas['prenom']),
                    'u_codeVente'   =>  htmlentities(strval($datas['code'])),
                    'Roles_idRoles' =>  htmlentities($datas['role'])
                );
            
            $db->insert('users', $params);
            
        }
        
        $options = array(
                'id'=>'useradd',
                'class'=>'form',
                'method'=>'post',
                'action'=>Route::url('users/add'));
        
        $elems = array(
                'nom'=>'text',
                'prenom'=>'text',
                'code'=>'text',
                'role'=>'select',
                'valider'=>'submit'
                );
        
        $form = new Form();
        $form->addOptions($options);
        $form->addElems($elems);
        
        $sql='select idRoles, r_role from roles';
        $select = $db->getRows($sql);
        
        $list = array();
        foreach($select as $s){
            $list[] = array($s->idRoles => $s->r_role);
        }
        
        $form->addSelOpt($list);
        
        $this->setVars('form', $form->formRender());
            
    }
    
    /**
     * Deleting user
     */
    public function supp() {
        $db = new Db();
        
        if($_POST){
            $datas = $_POST;
            $user = htmlentities($datas['user']);
            $db->delete('users', array('u_codeVente'=>$user));
            
            $this->setVars('user', $user);
        }
        
        
        $sql = 'select * from users where idUsers != 1';
        $result = $db->getRows($sql);
        
        $list = array();
        foreach ($result as $r){
            $list[$r->idUsers] = array($r->u_codeVente=>$r->u_prenom.' '.$r->u_nom);
        }
        
        $form = new Form();
        $form->addOptions(array("id"=>"suppuser", "class"=>"", "method"=>"post", "action"=>  Route::url('users/supp')));
        $form->addElems(array("user"=>"select", "valider"=>"submit"));
        $form->addSelOpt($list);
        
        $this->setVars('form', $form->formRender());
        
    }
}
