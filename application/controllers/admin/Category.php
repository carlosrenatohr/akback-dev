<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-12-16
 * Time: 11:57 PM
 */
class Category extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        var_dump('Init categories');
    }
}