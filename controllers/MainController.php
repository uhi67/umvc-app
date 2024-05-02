<?php

namespace app\controllers;

use Exception;
use uhi67\umvc\Controller;

/**
 * Controller class for the default page actions.
 */
class MainController extends Controller
{
    /**
     * The default action handles the index page.
     *
     * @throws Exception
     */
    public function actionDefault() {
        echo $this->app->render('main/index', []);
    }
}
