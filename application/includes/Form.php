<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Building and formating a form
 *
 * @author DigiHome
 */
class Form {
    // vars
    protected $form;
    protected $options = array();
    protected $elems = array();
    protected $selOpt = array();


    // init
    public function __construct() {
        
    }
    
    function addOptions($options){
        $this->options =  array_merge($options);
    }
    
    function getOptions(){
        return $this->options;
    }
    
    function addElems($elems){
        $this->elems=  array_merge($elems);
    }
    
    function getElems(){
        return $this->elems;
    }
    
    function addSelOpt($options){
        $this->selOpt=  array_merge($options);
    }
    
    function getSelOpt(){
        return $this->selOpt;
    }
    
    function formRender(){
        $this->form = '<form id="'.$this->options['id'].'" class="'.$this->options['class'].'" method="'.$this->options['method'].'" action="'.$this->options['action'].'" >';
        
        foreach ($this->elems as $key => $value) {
            if($value === 'submit'){
                $this->form .= '<input type="'.$value.'" name="'.$key.'" value="'.$key.'" />';
            }elseif($value==='select'){
                $this->form .= '<label for="'.$key.'">'.$key.'</label>';
                $this->form .= '<select form="'.$this->options['id'].'" name="'.$key.'">';
                if(isset($this->selOpt)&&$this->selOpt!=NULL){
                    foreach ($this->selOpt as $k=>$v) {
                        foreach ($v as $code => $name) {
                            $this->form .= '<option value="'.$code.'">'.$name.'</option>';
                        }
                    }
                }
                $this->form .= '</select>';
            }else{
                $this->form .= '<label for="'.$key.'">'.$key.'</label>';
                $this->form .= '<input id="'.$key.'" type="'.$value.'" name="'.$key.'" />';
            }
        }
        
        $this->form .= '</form>';
        
        return $this->form;
    }
}
