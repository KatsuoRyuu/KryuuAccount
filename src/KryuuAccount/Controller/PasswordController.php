<?php
namespace KryuuAccount\Controller;


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
 * and shall be written in one of the following ways: ?????????, Ryuu Technology 
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

 * @version 20140506 
 * @link https://github.com/KatsuoRyuu/
 */

use Zend\View\Model\ViewModel,
    KryuuAccount\Controller\StandardController,
    KryuuAccount\InputFilter\Password,
    KryuuAccount\Form\Password,
    KryuuAccount\Mail\Message;

class PasswordController extends StandardController {
	

	public function renewAction()
	{
		$viewModel = new ViewModel();
		$viewModel->setTemplate('renew.phtml');
		
		$message = NULL;
		
        $form = new Account\Form\Renew();
        
        $this->events()->trigger(__FUNCTION__.'.form', $this, array('form'=>$form));
        
        $form->get('submit')->setLabel('Renew');
        
        $this->events()->trigger(__FUNCTION__.'.form.post', $this, array('form'=>$form));
		
        
		if (!$this->params()->fromRoute('id')) 
		{
            $message = $this->translate('User was not found');
			$viewModel->setTemplate('error.phtml');
		} 
		else 
		{
			$user = $this->entityManager()
	    		->getRepository('KryuuAccount\Entity\User')
	    		->findOneBy(array('id' => $this->params()->fromRoute('id')));
			
			if ($user->getPasswordResetDate() == 0 && md5($user->getPasswordResetDate().$user->getId().$user->getPasswordResetDate()) != $this->params()->fromRoute('passwordCode'))
			{
				$message = $this->translate('Password change request not valid, Please request a password change from the login screen.');
				$viewModel->setTemplate('error.phtml');
			} else {
                
				$request = $this->getRequest();	
				if ($request->isPost()) 
				{
		        	$filter = new InputFilter\RenewPasswordFilter();
		            $form->setInputFilter($filter->getInputFilter());
		            $form->setData((array) $request->getPost());
	
	            	if ($form->isValid()) 
	            	{
						$data = $form->getData();
	            		$newPass = $data['newCredential'];

				        $bcrypt = new Bcrypt;
				        $bcrypt->setCost($this->getZfcUserOptions()->getPasswordCost());
				
				        $pass = $bcrypt->create($newPass);
				        $user->setPassword($pass);
						$user->setPasswordResetDate(Null);
                        $this->entityManager()->persist($user);
						$this->entityManager()->flush();
                        
                        $message = $this->translate('Your password has been renewed, please goto login.');
                        $viewModel->setTemplate('status.phtml');
					}
				}

				
			}

			$viewModel->setVariables(array(
				'formAction'=> array('id' => $this->params()->fromRoute('id'),'passwordCode' => $this->params()->fromRoute('passwordCode')),
				'form'		=> $form,
				'user'		=> $user,
				'message' 	=> $message,
			));
			
		}	
		return $viewModel;
	}
    
	public function lostAction()
	{
        $viewModel = new ViewModel();
		$message = '';
        
        $form = new KryuuAccount\Form\Password\Lost();
        
        $this->events()->trigger(__FUNCTION__.'.form', $this, array('form'=>$form));
        
        $form->get('submit')->setValue('Send');
        $form->get('submit')->setLabel('Send');
		        
        $this->events()->trigger(__FUNCTION__.'.form.post', $this, array('form'=>$form));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
        	$filter = new InputFilter\Lost();
            $form->setInputFilter($filter->getInputFilter());
            $form->setData((array) $request->getPost());

            if ($form->isValid()) {
                
                $data = $form->getData();
                $user = $this->entityManager()
                    ->getRepository('KryuuAccount\Entity\User')
                    ->findOneBy(array('email' => $data['email']));
				if(!$user) {
                    
					$message = $this->translate("We are sorry, but we can't find the email you requested a password renewal for.");
                    $viewModel->setTemplate('error.phtml');
				} else {
                    
                    $message = new Message();
                    $message->__set($this->configuration('mailer'),'reply');
                    $message->__set($this->translate('Password renewal'),'subject');
                    
                    /*
                     *  Starting the template rendering.
                     */ 
                    $template = new ViewModel();
                    $template->setTemplate('mail-template.phtml');
                    $template->setVariables(array(
                        'fullname'      => $user->getFirstname().' '.$user->getLastname(),
                        'id'            => $user->getId(),
                        'passphrase'    => md5($user->getPasswordResetDate().$user->getSerial().$user->getPasswordResetDate()),
                    ));
                    
                    $content = $template->render();  
                          
                    $message->__set(array('html' => $content, ),'message');
                    $message->__add($user->getEmail(),'recievers');
                    
                    $this->sendMail($message);
                                        
					$user->setPasswordResetDate(mktime(0, 0, 0, date("m") , date("d"),   date("Y")));
                    $this->entityManager()->persist($user);
					$this->entityManager()->flush();
                    
					$this->flashMessenger()->message( "Found you! an email is on the way." );
				}
            }
        }
        return array(
        	'form' 		=> $form,
        	'message' 	=> $message
			);
	}
    
    
}
