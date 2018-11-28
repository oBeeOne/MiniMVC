<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Shows a debug window
 * 
 * @param type $var
 * @param type $comment
 */
function debug($var, $comment=NULL){
    
    if(Config::$debug>0){
        $backtrace = debug_backtrace();

        echo '<pre class="debug">';
        echo "<a href='#'>".$backtrace[0]['file']." line ".$backtrace[0]['line']."</a>";
        if($comment!=NULL){
            echo "<h3>Dump de $comment dans la fonction ".$backtrace[1]['function']."()</h3>";
        }
        var_dump($var);
        echo '</pre>';
    }
}

/**
 * Getting identity if exists
 * If not, returns to login page
 */
function getIdentity(){
    $auth = new Auth();
    
    if($auth->user('idUsers')){
        echo "<div id='logHeader'>";
        echo "<p class='logged'>Connecté en tant que < ".$auth->user('u_codeVente')." : ".$auth->user('u_prenom')." ".$auth->user('u_nom')." > niveau &rarr; ".$auth->user('r_role');
        echo "<a href='".Route::url('auth/logout')."' title='déconnexion'><span class='logoff'></span></a></p>";
        echo "</div>";                                    
    }  else {
        header('Location: '.Route::url('auth'), 301);
    }
}

/**
 * Checking if request is POST
 * @return boolean
 */
function isPost(){
    if($_POST){
        return true;
    }else{
        return false;
    }
}

/**
 * Getting value of a form element in POST
 * @param type $elem
 * @return type
 */
function getVal($elem){
    if(isPost()){
        $data = $_POST;
        $val = htmlentities($data[$elem]);
        return $val;
    }
}

/**
 * Checking for duplicate entries in database
 * @param type $arr the list to check
 * @param type $val the value to compare
 */
function isUnique($arr, $val, $field){
    foreach ($arr as $k=>$v){
        if($v->$field === $val){
            return false;
        }
    }
    return true;
}

/**
 * Checks if phone model already exists in database
 * @param type $model
 * @param type $field
 * @param type $ean
 * @return boolean
 */
function isReferenced($model, $field, $ean){
    foreach ($model as $k=>$v){
        if($v->$field === $ean){
            return true;
        }
    }
    return false;
}

/**
 * Builds the HTML elements for ajax request return in tel/info view
 * @param object $history
 * @return string returns the xhr object datas
 */
function buildHistory($history){
    $response = "";
    foreach($history as $h){

        $response .= "<tr>";
        $response .= "<td>$h->f_marque</td>";
        $response .= "<td>$h->m_desc</td>";
        $response .= "<td>$h->m_gu</td>";
        $response .= "<td>$h->s_imei</td>";

        if(!is_null($h->mv_date)){
            $response .= "<td>$h->mv_date</td>";
        }else{
            $response .= "<td>$h->s_dateAjout</td>";
        }

        if(!is_null($h->mv_user)){
            $response .= "<td>$h->mv_user</td>";
        }else{
            $response .= "<td>$h->s_user</td>";
        }

        if(!is_null($h->c_move)){
            $response .= "<td>$h->c_move</td>";
        }else{
            $response .= "<td>Recep Stock</td>";
        }
        $response .= "</tr>";
    }
    return $response;
}