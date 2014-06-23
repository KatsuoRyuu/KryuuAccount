<?php

namespace KryuuAccount\InputFilter\Password;

use Zend\Filter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RenewPasswordFilter implements InputFilterAwareInterface
{
	
	protected $inputFilter;
	
	public function __construct()
	{
        $filter = new InputFilter();
					
       $filter->add(array(
            'name'       => 'newCredential',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $filter->add(array(
            'name'       => 'newCredentialVerify',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
                array(
                    'name' => 'identical',
                    'options' => array(
                        'token' => 'newCredential'
                    )
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
		$this->inputFilter = $filter;
	}
	
	public function getInputFilter()
	{
		return $this->inputFilter;
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
}