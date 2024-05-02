<?php
/*
|--------------------------------------------------------------------------
| The main configuration file of the application
|--------------------------------------------------------------------------
*/

use app\controllers\MainController;
use uhi67\umvc\App;

return [
    // Index 0 or 'class' declares the class of the [main] component.
    App::class,
    'application_env' => 'development',
    'mainControllerClass' => MainController::class,
    'layout'=>'layout',

    // Define the components to load in GUI mode
    'components' => [
    ],

    // Declare the components to load in CLI mode. If the key is not present, the default is the content of 'components'.
    // May contain full component definitions, or simple component names referring to a component defined in 'components'.
    'cli_components' => [
    ],
];
