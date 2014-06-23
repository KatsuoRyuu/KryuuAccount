<?php
namespace KryuuAccount;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'KryuuAccount\Form\Login'                => 'ZfcUser\Form\Login\Login',
                'KryuuAccount\Authentication\Adapter\Db' => 'KryuuAccount\Authentication\Adapter\Db',
            ),
            'factories' => array(
                'kryuu-account_login_form' => function ($sm) {
                    $options = $sm->get('zfcuser_module_options');
                    $form = new Form\Login\Login(null, $options);
                    $form->setInputFilter(new Form\Login\LoginFilter($options));
                    return $form;
                },
                // We alias this one because it's ZfcUser's instance of
                // Zend\Authentication\AuthenticationService. We don't want to
                // hog the FQCN service alias for a Zend\* class.
                'zfcuser_auth_service' => function ($sm) {
                    return new \Zend\Authentication\AuthenticationService(
                        $sm->get('ZfcUser\Authentication\Storage\Db'),
                        $sm->get('ZfcUser\Authentication\Adapter\AdapterChain')
                    );
                },
            ),
        );
    }
}