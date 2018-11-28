<?php

class AuthController extends Controller {
    
    function index(){
        
    }
    
    function login(){
        if(isset($_POST)){
            $auth = new Auth();
            $params = array($_POST['login'], sha1($_POST['pwd']));
                        
            if($auth->login($params)){
                $this->redirect('index');
            }  else {
                echo "<script type='javascript'>alert('Utilisateur inconnu !')</script>";
            }
        }
   }
    
    function logout(){
        Session::end();
        $this->redirect('index');
    }
}