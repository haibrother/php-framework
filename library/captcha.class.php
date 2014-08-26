<?php
/*
 *图片验证码
 **/
 class Captcha extends Common
 {
    
    public function __construct(){
        //$this->init('captcha');
    }
    
    public function check(){
        if(Session::get('captcha')==$this->getData('captcha_img')){
            echo 1;
            return 1;
        }else{
            echo 0;
            return 0;
        }
    }
    
    /*
     *生成验证码图片
     **/
     public function index()
     {
        require_once(BASEPATH.'/system/library/captcha/captcha.php');
        header('P3P: CP=CAO PSA OUR');
        $captcha = new SimpleCaptcha();
        $captcha->lineWidth = 2;
        $captcha->CreateImage();
     }
     
     public function test()
     {
        var_dump(Session::get('captcha'));
     }
     
 }