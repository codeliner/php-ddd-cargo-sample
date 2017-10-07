<?php

use Zend\ServiceManager\ServiceManager;

return function($config): ServiceManager {
    $dependencies = $config['dependencies'];
    $dependencies['services']['config'] = $config;

    // Build container
    return new ServiceManager($dependencies);
};
