<?php

namespace KryuuAccount\Controller\Plugin;

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

 * @version 20140711 
 * @link https://github.com/KatsuoRyuu/
 */

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Authentication\Adapter\AdapterChain as AuthAdapter;

class UserAccountData extends AbstractPlugin{
    
    
    
    /**
     * PLEASE NOTE.
     * This class as seen is not complete and will be extended with new functions on the fly
     */
    
    
    public function setConfigService($serviceLocator){
        $this->serviceLocator = $serviceLocator;
        $this->configService = $serviceLocator->get('KryuuAccount\Config');
    }
    
    public function loadMethods(){
        
    }
    
    public function __call($method, $args){
        
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        } else {
            $config = $this->configService->get(array('user_data_methods',$method));
            $service = $this->serviceLocator->get($config['service']);
            $functionName = $config['name'];
            
            $this->$functionName = function () use ($args,$service,$config) {
                $func = $config['function'];
                return $service->$func($args);
            };
            return $this->$functionName();
        }
    }
    
}
