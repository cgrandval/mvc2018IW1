<?php

namespace Mvc\Controllers;
use Mvc\Core\View;

class PagesController
{
    public function defaultAction()
    {
        $v = new View('homepage', 'back');
        $v->assign('pseudo', 'prof');
    }
}
