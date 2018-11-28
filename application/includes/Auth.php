<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Auth{
    
    /**
     * Checking login
     * @param type $params
     * @return boolean
     */
    function login($params){
        
        $db = new Db();
        $sql = 'select * from users join roles on users.Roles_idRoles = roles.idRoles where users.u_codeVente = ? and roles.r_pwd = ?';
        $result = $db->getRow($sql, $params);
        
        if(count($result)>0){
            $_SESSION['auth'] = $result;
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
     * Checking if user is allowed to access pages or page's elements
     * @param type $level
     * @return boolean
     */
    function allow($level){
        $db = new Db();
        $sql = 'select * from roles';
        $result = $db->getRows($sql);
        $role = array();
        foreach ($result as $r){
            $role[$r->r_role]=$r->idRoles;
        }
        if(!$this->user('role')){
            return false;
        }elseif ($role[$level] < $this->user('role')) {
            return false;
        }else{
            return true;
        }
    }
    
    /**
     * Returns a required field value from session storage
     * @param string $field
     * @return boolean
     */
    function user($field){
        if($field=='role') $field='Roles_idRoles';
        if(isset($_SESSION['auth']->$field)){
            return $_SESSION['auth']->$field;
        }else{
            return false;
        }
    }
}   
