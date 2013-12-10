<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Define shortcuts
define('DS', '/');
define('CONFIG_DIR', 'Tess' . DS . 'Core' . DS . 'Config');

// Require neccesary files
require_once('vendor' . DS . 'autoload.php');
require_once('Tess/Core' . DS . 'App.php');

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Debug\Debug;
use Tess\Core\App;
use Tess\Core\test;

// Enable pretty Exceptions
Debug::enable();

// Instanciate bootstrap class 
$App = new App();

// Loading services from the services.yml file
$loader = new YamlFileLoader($App, new FileLocator(CONFIG_DIR));
$loader->load('services.yml');




$App->run();

