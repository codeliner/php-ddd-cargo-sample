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
                                        'trackingid' => '[a-zA-Z0-9_-]{36,36}',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            )
                        ),
                    ),
                ),
            ),
            'assign-itinerary' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/cargo/assign-itinerary/trackingid/[:trackingid]/itinerary/[:index]',
                    'constraints' => array(
                        'trackingid' => '[a-zA-Z0-9_-]{36,36}',
                        'index' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Cargo',
                        'action'        => 'assign-itinerary',
                    ),
                ),
            )
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'main_navigation'   => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'cargo_form'        => 'Application\Form\Service\CargoFormFactory',
            'cargo_repository'  => 'Application\Service\CargoRepositoryFactory',
            'routing_service'   => 'Application\Service\RoutingServiceFactory',
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
                'type'     => 'PhpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
        'factories' => array(
            'Application\Controller\Cargo' => 'Application\Controller\Service\CargoControllerFactory'
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
            ),
        )
    ),
    'caches' => array(
        'filesystem_cache' => array(
            'adapter' => array(
                'name'    => 'filesystem',
                'options' => array(
                    'cache_dir' => __DIR__ . '/../../../data/cache'
                ),
            ),
            'plugins' => array(
                // Don't throw exceptions on cache errors
                'exception_handler' => array(
                    'throw_exceptions' => false
                ),
                // We store arrays on filesystem so we need to serialize them
                'Serializer'
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
