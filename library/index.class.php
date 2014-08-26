<?php
/*
 *默认跳转页面
 **/
class Index extends Common
{
    public function index()
    {
        header("Location:./cn/newAccount.html?action=0");
    }
}