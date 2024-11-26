<?php

/*
https://cdn.dribbble.com/userupload/14630437/file/original-e96945c1fd3d3f7eb8b487eed9ffbbd6.png?resize=1905x1429&vertical=center
*/

class AdminController
{
    public function index()
    {
        include_once("Views\AdminPanel\Index.html");
    }

    public function users()
    {
        include_once("Views\AdminPanel\Users.html");
    }
}   

?>