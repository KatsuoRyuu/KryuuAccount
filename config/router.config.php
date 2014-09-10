<?php

namespace KryuuAccount;

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
 * and shall be written in one of the following ways: Ryuu Technology 
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

 * @version 20140730 
 * @link https://github.com/KatsuoRyuu/
 */
return array(
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
);
