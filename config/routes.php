<?php

return function (\Zend\Expressive\Application $app): void {
    $app->get('/', \Codeliner\CargoUI\Main::class);
    $app->get('/api/locations', \Codeliner\CargoBackend\Http\Action\GetLocations::class);
    $app->get('/api/cargos', \Codeliner\CargoBackend\Http\Action\GetCargos::class);
    $app->post('/api/cargos', \Codeliner\CargoBackend\Http\Action\CreateCargo::class);
    $app->get('/api/cargos/{trackingId}', \Codeliner\CargoBackend\Http\Action\GetCargo::class)
        ->setOptions([
            'tokens' => [
                'trackingId' => '[\\w+-]{36,36}',
            ],
        ]);
    $app->put('/api/cargos/{trackingId}', \Codeliner\CargoBackend\Http\Action\UpdateCargo::class)
        ->setOptions([
            'tokens' => [
                'trackingId' => '[\\w+-]{36,36}',
            ],
        ]);
    $app->get('/api/cargos/{trackingId}/routecandidates', \Codeliner\CargoBackend\Http\Action\GetRouteCandidates::class)
        ->setOptions([
            'tokens' => [
                'trackingId' => '[\\w+-]{36,36}',
            ],
        ]);
};
