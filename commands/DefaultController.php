<?php
namespace app\commands;

use Exception;
use ReflectionException;
use uhi67\umvc\Command;

class DefaultController extends Command
{
    /**
     * The default action is called when no specific action is present in the command
     * @return int
     */
    public function actionDefault()
    {
        echo "The default command is a sample CLI command.", PHP_EOL;
        echo "Run `php app default/help` for more details.", PHP_EOL, PHP_EOL;
        return 0;
    }

    public function actionHelp()
    {
        echo "The default command is a sample CLI command.", PHP_EOL;
        echo "Here you can describe the details of the actions.", PHP_EOL;
        echo PHP_EOL;
        return 0;
    }
}
