<?php

namespace KryuuAccount;

defined('__AUTHORIZE__') or define('__AUTHORIZE__','bjyauthorize');

$mainRoute = 'kryuu-account';

$router     = include(__DIR__.'/router.config.php');
$service    = include(__DIR__.'/services.config.php');
$authorize  = include(__DIR__.'/authorize.config.php');
$navigation = include(__DIR__.'/navigation.config.php');

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
    
    __AUTHORIZE__       => $authorize,
    
    'router'            => $router,
    
    'navigation'        => $navigation,
    
    'service_manager'   => $service,
    
    'controllers' => array(
        'invokables' => array(
            'zfcuser' => 'KryuuAccount\Controller\AccountController',
            'KryuuAccount\Account'  => 'KryuuAccount\Controller\AccountController',
            'KryuuAccount\Password' => 'KryuuAccount\Controller\PasswordController',
            'KryuuAccount\status'   => 'KryuuAccount\Controller\StatusController',
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'kryuuaccount' => __DIR__ . '/../view',
        ),
    ),
    'module_layouts' => array(
        __NAMESPACE__ => __THEME__.'/layout/account',
    ),
);