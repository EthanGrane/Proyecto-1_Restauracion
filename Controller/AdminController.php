<?php

/*
https://cdn.dribbble.com/userupload/14630437/file/original-e96945c1fd3d3f7eb8b487eed9ffbbd6.png?resize=1905x1429&vertical=center
*/

require_once("Framework/ViewSystem/ViewSystem.php");


class AdminController
{
    public function index()
    {
        ViewSystem::PrintAdminView("Index");
    }

    public function users()
    {
        ViewSystem::PrintAdminView("Users");
    }

    public function products()
    {
        ViewSystem::PrintAdminView("Products");
    }

    public function discounts()
    {
        ViewSystem::PrintAdminView("Discounts");
    }
}   

?>