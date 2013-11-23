<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'trackingid' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/trackingid/[:trackingid]',
                                    'constraints' => array(
                                        'trackingid' => '[a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'main_navigation'   => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'cargo_form'        => 'Application\Form\Service\CargoFormFactory',
            'cargo_repository'  => function($sl) {
                $em = $sl->get('doctrine.entitymanager.orm_default');
                return $em->getRepository('Application\Domain\Model\Cargo\Cargo');
            },
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
        'factories' => array(
            'Application\Controller\Cargo' => function($controllerLoader) {
                $serviceManager = $controllerLoader->getServiceLocator();
                
                $cargoRepository = $serviceManager->get('cargo_repository');
                
                $cargoController = new Application\Controller\CargoController();
                $cargoController->setCargoRepository($cargoRepository);
                $cargoController->setCargoForm($serviceManager->get('cargo_form'));
                return $cargoController;
            }
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                //Define custom doctrine types to map the ddd value objects
                'types' => array(
                    'uid'           => 'Application\Infrastructure\Persistence\Doctrine\Type\UID',
                    'trackingid'    => 'Application\Infrastructure\Persistence\Doctrine\Type\TrackingId',
                    'voyagenumber'    => 'Application\Infrastructure\Persistence\Doctrine\Type\VoyageNumber',
                ),
            ),
        ),
        'driver' => array(
            'application_module_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Application/Domain/Model/Cargo/'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application' => 'application_module_driver',
                )
            )
        )
    ),
    'navigation' => array(
        'default' => array(
            'home' => array(
                'route' => 'home',
                'label' => 'home'
            ),
            'cargo' => array(
                'type' => 'uri',
                'label' => 'Cargo',
                'pages' => array(
                    'list' => array(
                        'route' => 'application/default',
                        'controller' => 'cargo',
                        'action' => 'index',
                        'label' => 'list Cargos'
                    ),
                    'add' => array(
                        'route' => 'application/default',
                        'controller' => 'cargo',
                        'action' => 'add',
                        'label' => 'add Cargo'
                    )
                )
            )
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
