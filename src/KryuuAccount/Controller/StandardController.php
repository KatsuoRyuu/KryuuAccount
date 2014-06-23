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

 * @version 20140614 
 * @link https://github.com/KatsuoRyuu/
 */

use KryuuAccount\Controller\EntityUsingController,
    Zend\Mail,
    Zend\Mime;

class StandardController extends EntityUsingController{
    
    const ROUTE_LOGOUT = "zfcuser/logout";
    const ROUTE_LOGIN  = "zfcuser/login";
    
    private function sendMail($message){
        
        $mail = new Mail\Message();
        
        $parts = array();
        
        $bodyMessage = new Mime\Part();
        $bodyMessage->type = 'text/plain';
        
        $parts[] = $bodyMessage;
        
        if ($message->__get("file")->count() > 0){
            foreach ($message->__get("file") as $file) {
                $fileRepo = $this->getServiceLocator()->get('FileRepository');
                $fileContent = fopen($fileRepo->getRoot().'/'.$file->getSavePath(), 'r');
                
                $attachment = new Mime\Part($fileContent);
                $attachment->type = $file->getMimetype();
                $attachment->filename = $file->getName();
                $attachment->encoding = Mime\Mime::ENCODING_BASE64;
                $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
                $parts[] = $attachment;
            }

        }

        $bodyPart = new Mime\Message();

        // add the message body and attachment(s) to the MimeMessage
        $bodyPart->setParts($parts);
       
        /*
         * getting the from the sender.
         */
        $from = $message->__get('reply');
        $fromName = array_keys($from);
        $fromMail = array_values($from);
        
        foreach($fromName as $index => $name){
            $mail
                ->addFrom($fromMail[$index],$name)
                ->addReplyTo($fromMail[$index],$name)
                ->setSender($fromMail[$index],$name);
        }
        
        /*
         * getting the from the sender.
         */
        $recievers = $message->__get('recievers');
        $recieversMail = array_values($recievers);
        
        foreach($recieversMail as $email){
            $mail->addTo($email);
        }
        
        $mail
            ->setSubject($message->__get('subject'))
            ->setBody($bodyPart)
            ->setEncoding("UTF-8")
            ->setBody($bodyPart);
        // Setup SMTP transport using LOGIN authentication
        
        $this->getMailTransport()->send($mail);
        
    }
}
