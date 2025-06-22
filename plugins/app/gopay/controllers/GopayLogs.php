<?php

namespace App\Gopay\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class GopayLogs extends Controller
{
    public $implement = ['Backend\Behaviors\ListController'];

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('App.Gopay', 'gopay', 'logs');
    }
}
