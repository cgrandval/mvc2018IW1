<?php

use Mvc\Models\Users;
use Mvc\Controllers\UsersController;
use Mvc\Controllers\PagesController;
use Mvc\VO\DbDriver;
use Mvc\VO\DbHost;
use Mvc\VO\DbName;
use Mvc\VO\DbUser;
use Mvc\VO\DbPwd;

return [
    DbDriver::class => function($container) {
        return new DbDriver($container['config']['db']['driver']);
    },
    DbHost::class => function($container) {
        return new DbHost($container['config']['db']['host']);
    },
    DbName::class => function($container) {
        return new DbName($container['config']['db']['name']);
    },
    DbUser::class => function($container) {
        return new DbUser($container['config']['db']['user']);
    },
    DbPwd::class => function($container) {
        return new DbPwd($container['config']['db']['pwd']);
    },
    Users::class => function($container) {
        $DbDriver = $container[DbDriver::class]($container);
        $DbHost = $container[DbHost::class]($container);
        $DbName = $container[DbName::class]($container);
        $DbUser = $container[DbUser::class]($container);
        $DbPwd = $container[DbPwd::class]($container);

        return new Users($DbDriver, $DbHost, $DbName, $DbUser, $DbPwd);
    },
    UsersController::class => function($container) {
        $usersModel = $container[Users::class]($container);
        return new UsersController($usersModel);
    },
    PagesController::class => function($container) {
        return new PagesController();
    },
];