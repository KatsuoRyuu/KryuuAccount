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


class UserEditorServiceFactory implements FactoryInterface {
    
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
        $this->authService = $this->serviceLocator->get($this->config->get(['auth_service']));

        return $this;
    }
    
    public function changeUserDisplayName($dispalyName){
        if (!$this->hasIdentity()){
            return false;
        }
    }
    
    public function changeUserPassword($password){
        if (!$this->hasIdentity()){
            return false;
        }
    }
    
    public function changeUserEmail($email){
        if (!$this->hasIdentity()){
            return false;
        }
    }
    
    public function changeUserRole($role){
        if (!$this->hasIdentity()){
            return false;
        }
        
    }
    
    public function changeUsername($username){
        if (!$this->hasIdentity()){
            return false;
        }
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
