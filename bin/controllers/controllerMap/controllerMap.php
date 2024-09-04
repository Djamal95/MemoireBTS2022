<?php

namespace Epaphrodites\controllers\controllerMap;

use Epaphrodites\controllers\controllers\api;
use Epaphrodites\controllers\controllers\main;
use Epaphrodites\controllers\controllers\users;
use Epaphrodites\controllers\controllers\chats;
use Epaphrodites\controllers\controllers\setting;
use Epaphrodites\controllers\controllers\dashboard;
use Epaphrodites\controllers\controllers\student;
use Epaphrodites\controllers\controllers\program;
use Epaphrodites\controllers\controllers\documents;

trait controllerMap
{

    /**
     * Returns an instance of the 'main' controller.
     *
     * @return object An instance of the 'main' controller.
     */
    private function mainController():object
    {
        return new main;
    }    

    /**
     * Returns an array mapping controllers to their respective instances and methods.
     *
     * @return array The mapping of controllers with their instances and methods.
     */
    private function controllerMap(): array
    {
        return [
			'documents' => [ new documents, 'SwitchControllers', true, 'documentsFolder', _DIR_ADMIN_TEMP_ ],
			'program' => [ new program, 'SwitchControllers', true, 'programFolder', _DIR_ADMIN_TEMP_ ],
			"student" => [ new student, 'SwitchControllers', true, 'studentFolder', _DIR_ADMIN_TEMP_ ],
            "api" => [ new api, 'SwitchApiControllers', false ],
            "users" => [ new users, 'SwitchControllers', true, 'usersFolder', _DIR_ADMIN_TEMP_ ],
            "chats" => [ new chats, 'SwitchControllers', true, 'chatsFolder', _DIR_ADMIN_TEMP_ ],
            "setting" => [ new setting, 'SwitchControllers', true, 'settingFolder', _DIR_ADMIN_TEMP_ ],
            "dashboard" => [ new dashboard, 'SwitchControllers', true, 'dashboardFolder', _DIR_ADMIN_TEMP_ ],
        ];
    }
}