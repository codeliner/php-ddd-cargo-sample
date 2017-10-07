<?php

use Zend\ServiceManager\ServiceManager;

return function(): ServiceManager {
    $config = require __DIR__ .'/config.php';
    $dependencies = $config['dependencies'];
    $dependencies['services']['config'] = $config;

    // Build container
    return new ServiceManager($dependencies);
};
