<?php

use Zend\ServiceManager\ServiceManager;

// Load configuration
$config = require 'config/config.php';

// Build container
$container = new ServiceManager($config['dependencies']);

// Inject config
$container->setService('config', $config);

return $container;
