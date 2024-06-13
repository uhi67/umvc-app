<?php
namespace app\lib;

use Exception;

class Install extends \uhi67\umvc\Install {
    /**
     * Run by composer after install.
     * Warning: composer may be run by root, be careful with owners of created files
     *
     * 1. Framework post-install
     * 2. Version number
     *
     * @throws Exception
     */
    public static function postInstall() {
        // 1. Framework post-install
        parent::postInstall();

        // 2. Extract version number into file
        $version = trim(exec('git describe --tags --abbrev=1'));
        if($version) {
            $versionOutputFilename = dirname(__DIR__).'/version.txt';
            file_put_contents($versionOutputFilename, $version);
            echo "Application version is $version (logged into $versionOutputFilename)\n\n";
        }
    }
}
