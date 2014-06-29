<?php

namespace KryuuAccount;

return array(
    __NAMESPACE__ => array(
        'mailer' => array( 'Technical Support' => 'spawn-technicalsupport@drake-development.org' ),
        'user-management' => array(
            'user-states'=> array(   
                'active'=> 'active-member',
                'expired'=>'member',
                'neutral'=>'user',
            ),
        ),
        'auth_service'  => 'zfcuser_auth_service',
        'user_entity'   => 'KryuuAccount\Entity\User',
        'role_entity'   => 'KryuuAccount\Entity\Role',
    ),
    
    'controllers' => array(
        'invokables' => array(
            'zfcuser' => 'KryuuAccount\Controller\AccountController',
            'KryuuAccount\Account'=> 'KryuuAccount\Controller\AccountController',
            'KryuuAccount\Password' => 'KryuuAccount\Controller\PasswordController',
            'KryuuAccount\status' => 'KryuuAccount\Controller\StatusController',
        ),
    ),

    /*
     * Routing Example
     */

    'router' => array(
        'routes' => array(
            'zfcuser' => array(
                'type'    => 'literal',
                'options' => array(
                    'route' => '/kaccount',
                    'defaults' => array(
                        'controller'    => 'KryuuAccount\Account',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    /**
                     * Password Routes
                     */
                    'password' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/password',
                            'defaults' => array(
                                'controller' => 'KryuuAccount\Password',
                                'action' => 'password',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'renew' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/renew',
                                    'defaults' => array(
                                        'controller' => 'KryuuAccount\Password',
                                        'action' => 'renew',
                                    ),
                                ),
                            ),
                            'lost' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/lost',
                                    'defaults' => array(
                                        'controller' => 'KryuuAccount\Password',
                                        'action' => 'lost',
                                    ),
                                ),
                            ),
                            'change' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/change',
                                    'defaults' => array(
                                        'controller' => 'KryuuAccount\Password',
                                        'action' => 'change',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'status' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/status[/:msg]',
                            'constraints' => array(
                                'msg' => '[a-zA-Z0-9_]+',
                            ),
                            'defaults' => array(
                                'controller' => 'KryuuAccount\status',
                                'action' => 'status',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            'kryuu_account_editor'       => 'KryuuAccount\Service\UserEditorServiceFactory',
            'KryuuAccount\Config'           => 'KryuuAccount\Service\ConfigServiceFactory',
        ),
        'invokables'  => array(
            //'BjyAuthorize\View\RedirectionStrategy'                   => 'BjyAuthorize\View\RedirectionStrategy',
        ),
        'aliases'     => array(
            //'bjyauthorize_zend_db_adapter'                            => 'Zend\Db\Adapter\Adapter',
        ),
        'initializers' => array(
            //'BjyAuthorize\Service\AuthorizeAwareServiceInitializer'   => 'BjyAuthorize\Service\AuthorizeAwareServiceInitializer'
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'kryuuaccount' => __DIR__ . '/../view',
        ),
    ),
);