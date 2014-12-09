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
        'user_service'  => 'KryuuAccount\UserInfoService',
        'user_data_methods' => array(
            'getId' => array(
                'service'   => 'KryuuAccount\UserInfoService',
                'name'      => 'getId',
                'function'  => 'getId',
                'args'      => '',
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
    
    'doctrine'=> array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
    'zfcuser' => array(
        
        /**
         * User Model Entity Class
         *
         * Name of Entity class to use. Useful for using your own entity class
         * instead of the default one provided. Default is ZfcUser\Entity\User.
         * The entity class should implement ZfcUser\Entity\UserInterface
         */
        'user_entity_class' => 'KryuuAccount\Entity\User',
    ),
    'bjyauthorize' => array(
        
        /**
         * role providers simply provide a list of roles that should be inserted
         * into the Zend\Acl instance. the module comes with two providers, one
         * to specify roles in a config file and one to load roles using a
         * Zend\Db adapter.
         */
        'role_providers' => array(

            /**
             * here, 'guest' and 'user are defined as top-level roles, with
             * 'admin' inheriting from user
             */
            // this will load roles from the 'BjyAuthorize\Provider\Role\Doctrine'
            // service
			'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
			
            	'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'KryuuAccount\Entity\Role',
            ),
        ),
        /**
         * resource providers provide a list of resources that will be tracked
         * in the ACL. like roles, they can be hierarchical
         *  'resource_providers' => array(
         *      'BjyAuthorize\Provider\Resource\Config' => array(
         *          'Application\Controller\IndexController' => array(),
         *          'management' => array(),
         *      ),
         *  ),
         */
        'resource_providers' => array(
            'KryuuAccess\Provider\Resource\ObjectRepositoryProvider' => array(
			
            	'object_manager'    => 'doctrine.entitymanager.orm_default',
                'resource_entity_class' => 'KryuuAccess\Entity\Resource',
            ),
        ),

        /** 
         * rules can be specified here with the format:
         * array(roles (array), resource, [privilege (array|string), assertion])
         * assertions will be loaded using the service manager and must implement
         * Zend\Acl\Assertion\AssertionInterface.
         * *if you use assertions, define them using the service manager!*
         */
        'rule_providers' => array(
            'KryuuAccess\Provider\Rule\ObjectRepositoryProvider' => array(
			
            	'object_manager'    => 'doctrine.entitymanager.orm_default',
                'rule_entity_class' => 'KryuuAccess\Entity\Rule',
            ),
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