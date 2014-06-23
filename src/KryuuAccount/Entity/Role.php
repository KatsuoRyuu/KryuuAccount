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

use BjyAuthorize\Acl\HierarchicalRoleInterface,
    Doctrine\ORM\Mapping as ORM;

/**
 * An example entity that represents a role.
 *
 * @ORM\Entity
 * @ORM\Table(name="`kryuu_account_role`")
 */

class Role implements HierarchicalRoleInterface {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer 
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $roleId;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $name;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $description;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="KryuuAccount\Entity\Role")
     */
    protected $parent;
    
    
	    
    public function __construct(){
        
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
     * @return \KryuuAccount\Entity\Role
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getRoleId(){
        return $this->roleId;
    }
    
    /**
     * 
     * @param type $roleId
     * @return \KryuuAccount\Entity\Role
     */
    public function setRoleId($roleId){
        $this->roleId = $roleId;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * 
     * @param type $name
     * @return \KryuuAccount\Entity\Role
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getDescription(){
        return $this->description;
    }
    
    /**
     * 
     * @param type $description
     * @return \KryuuAccount\Entity\Role
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getParent(){
        return $this->parent;
    }
    
    /**
     * 
     * @param \KryuuAccount\Entity\Role $parent
     * @return \KryuuAccount\Entity\Role
     */
    public function setParent(Role $parent){
        $this->parent = $parent;
        return $this;
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
     * @return \KryuuAccount\Entity\Role
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
