<?php

namespace KryuuAccount\Entity;

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

use BjyAuthorize\Provider\Role\ProviderInterface,
    ZfcUser\Entity\UserInterface,
    Doctrine\ORM\Mapping as ORM,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface,
    Zend\Form\Annotation,
    Doctrine\Common\Collections\Collection,
    Doctrine\Common\Collections\ArrayCollection;


/**
 * @Annotation\Name("User")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * 
 * @ORM\Entity
 * @ORM\Table(name="kryuu_account_user")
 */

class User implements UserInterface, ProviderInterface{
    
    /**
     * @Annotation\Exclude()
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer 
     */
    protected $id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\text")
     * @Annotation\Flags({"priority": 600})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StringTrim"})
     * @ Annotation\Validator({"name":"StringLength"})
     * @Annotation\Options({"label":"About:"})
     * @Annotation\Attributes({"options":{"1":"PlaceHolder","2":"Test"}})
     * 
     * 
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $displayName;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", unique=true, length=255)
     */
    protected $email;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;
    
    /**
     * 
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $passwordReset;
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $state=0;
    
    /**
     * 
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="KryuuAccount\Entity\Role", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="kryuu_account_user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
    
    /**
     * 
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $createdTime=0;
    
    public function __construct(){
        $this->roles = new ArrayCollection();
    }
    
    /**
     * 
     * @return type
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * 
     * @param type $id
     * @return \KryuuAccount\Entity\User
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getDisplayName(){
        return $this->displayName;
    }
    
    /**
     * 
     * @param type $displayname
     * @return \KryuuAccount\Entity\User
     */
    public function setDisplayName($displayname){
        $this->displayName = $displayname;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getUsername(){
        return $this->username;
    }
    
    /**
     * 
     * @param type $username
     * @return \KryuuAccount\Entity\User
     */
    public function setUsername($username){
        $this->username = $username;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getEmail(){
        return $this->email;
    }
    
    /**
     * 
     * @param type $email
     * @return \KryuuAccount\Entity\User
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * 
     * @param type $password
     * @return \KryuuAccount\Entity\User
     */
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }
    
    /**
     * Will get the reset integer from the passwordReset variable
     * 
     * @return type
     */
    public function getPasswordReset(){
        return $this->passwordReset;
    }

    /**
     * For setting the password Reset date.
     * 
     * @param type $password
     * @return \KryuuAccount\Entity\User
     */
    public function setPasswordReset(){
        $this->passwordReset = time();
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getState() {
        return $this->state;
    }
    
    /**
     * 
     * @param type $state
     * @return type
     */
    public function setState($state) {
        $this->state = $state;
        return $this->state;
    }
    
    /**
     * 
     * @return type
     */
    public function getRoles(){
        return $this->roles;
    }
    
    /**
     * 
     * @param \KryuuAccount\Entity\Role $role
     */
    public function addRole(Role $role){
        $this->roles[] = $role;
    }
    
    /**
     * 
     * @return type
     */
    public function getCreatedTime(){
        return $this->createdTime;
    }
    
    /**
     * 
     * @param integer $role
     */
    public function setCreatedTime(){
        $this->createdTime = time();
    }
    
    /**
     * 
     * @param type $key
     * @return type
     */
    public function __get($key){
        return $this->$key;
    }
    
    /**
     * 
     * @param type $value
     * @param type $key
     * @return \KryuuAccount\Entity\User
     */
    public function __set($value, $key){
        $this->$key = $value;
        return $this;
    }
    
    /**
     * WARNING USING THESE IS NOT SAFE. there is no checking on the data and you need to know what
     * you are doing when using these.
     * This is used to exchange data from form and more when need to store data in the database.
     * and again ist made lazy, by using foreach without data checks
     * 
     * @param ANY $value
     * @param ANY $key
     * @return $value
     */
    public function populate($array){
        foreach($array as $key => $var){
            $this->$key = $var;
        }
        return $this;
    }
    
    /**
     * Get an array copy of the objects variables
     * 
     * @return type array
     */
    public function getArrayCopy(){
        return get_object_vars($this);
    }
    
}
