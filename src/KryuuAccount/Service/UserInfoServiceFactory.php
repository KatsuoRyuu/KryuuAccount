<?php

namespace KryuuAccount\Service;

/**
 * @encoding UTF-8
 * @note *
 * @todo *
 * @package PackageName
 * @author Anders Blenstrup-Pedersen - KatsuoRyuu <anders-github@drake-development.org>
 * @license *
 * The Ryuu Technology License
 *
 * Copyright 2014 Ryuu Technology by 
 * KatsuoRyuu <anders-github@drake-development.org>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * Ryuu Technology shall be visible and readable to anyone using the software 
 * and shall be written in one of the following ways: 竜技術, Ryuu Technology 
 * or by using the company logo.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *

 * @version 20140622 
 * @link https://github.com/KatsuoRyuu/
 */

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class UserInfoServiceFactory implements FactoryInterface {
    
    /**
     *
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;
    
    /**
     *
     * @var Array
     */
    private $config;
    
    /**
     *
     * @var Zend\Authentication\AuthenticationServiceuser
     */
    private $authService;
    
    /**
     * 
     * @var Identity
     */
    private $identity=null;
    
    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return boolean|\KryuuAccount\Service\UserEditorService
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
        $this->config = $this->serviceLocator->get('KryuuAccount/Config');
        $this->authService = $this->serviceLocator->get($this->config['auth_service']);

        return $this;
    }
    
    public function getUserDisplayName($userSearch){
        $this->getIdentity($userSearch);
        if (!$this->hasIdentity()){
            return false;
        }
        return $this->identity->getDisplayName();
    }
    
    public function getUserPassword($userSearch){
        $this->getIdentity($userSearch);
        if (!$this->hasIdentity()){
            return false;
        }
        return false;
    }
    
    public function getUserEmail($userSearch){
        $this->getIdentity($userSearch);
        if (!$this->hasIdentity()){
            return false;
        }
        return $this->identity->getEmail();
    }
    
    public function getUserRole($userSearch){
        $this->getIdentity($userSearch);
        if (!$this->hasIdentity()){
            return false;
        }
        return $this->identity->getRole();
    }
    
    public function getUsername($userSearch){
        $this->getIdentity($userSearch);
        if (!$this->hasIdentity()){
            return false;
        }
        return $this->identity->getUsername();
    }
    
    public function getIdentity($userSearch){
        $user = false;
        
        if(!$user){
            $user = $this->serviceLocator->get('Doctrine\ORM\EntityManager')->getRepository($this->config['user_entity'])->findOneBy(array('email'=>$userSearch));
        } 
        if (!$user){
            $user = $this->serviceLocator->get('Doctrine\ORM\EntityManager')->getRepository($this->config['user_entity'])->findOneBy(array('id'=>$userSearch));
        }
        if(!$user){
            $user = $this->serviceLocator->get('Doctrine\ORM\EntityManager')->getRepository($this->config['user_entity'])->findOneBy(array('username'=>$userSearch));
        } 
        if(!$user){
            throw new Zend\ServiceManager\Exception('Unable to find the user!');
        }
        
        $this->identity = $user;
        return $this->identity;
    }
    
    private function hasIdentity(){
        if ($this->identity != null){
            return true;
        } else if ($this->authService->hasIdentity()){
            $this->identity = $this->authService->getIdentity();
            return true;
        }
        return false;
    }
}
