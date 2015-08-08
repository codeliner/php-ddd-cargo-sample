<?php
$globalConfig = include __DIR__ . '/config.php';
$localConfig = (file_exists(__DIR__ . '/local.config.php'))? include __DIR__ . '/local.config.php' : [];

return [
    'services' => [
        'config' => \Zend\Stdlib\ArrayUtils::merge($globalConfig, $localConfig),
    ],
    'invokables' => [
        'cargo.ui.riot_compiler' => \Codeliner\CargoUI\RiotCompiler::class,
    ],
    'factories' => [
        'Zend\Expressive\Application' => Zend\Expressive\Container\ApplicationFactory::class,
        'cargo.ui' => \Codeliner\CargoUI\Factory\MainFactory::class,
    ],
];