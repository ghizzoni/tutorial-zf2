<?php
namespace Contato\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface; 

class Contato implements InputFilterAwareInterface
{
    public $id;
    public $nome;
    public $telefone_principal;
    public $telefone_secundario;
    public $data_criacao;
    public $data_atualizacao;
    protected $inputFilter;
 
    public function exchangeArray($data)
    {
        $this->id                   = (!empty($data['id'])) ? $data['id'] : null;
        $this->nome                 = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->telefone_principal   = (!empty($data['telefone_principal'])) ? $data['telefone_principal'] : null;
        $this->telefone_secundario  = (!empty($data['telefone_secundario'])) ? $data['telefone_secundario'] : null;
        $this->data_criacao         = (!empty($data['data_criacao'])) ? $data['data_criacao'] : null;
        $this->data_atualizacao     = (!empty($data['data_atualizacao'])) ? $data['data_atualizacao'] : null;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception('Não utilizado.');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            // input filter para campo de id
            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'), #transforma string para inteiro
                )
            ));
            
            // input filter para campo de nome
            $inputFilter->add(array(
                'name' => 'nome',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), #remove xml e html da string
                    array('name' => 'StringTrim'), #remove espaços do início e do final da string
                    array('name' => 'StringToUpper'), #transforma string para maiusculo
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mínimo de caracteres inaceitáveis %min%.',
                                \Zend\Validator\StringLength::TOO_LONG => 'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));
                                
            //input filter para campó de telefone principal
            $inputFilter->add(array(
                'name' => 'telefone_principal',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), #remove xml e html da string
                    array('name' => 'StringTrim'), #remove espaços do início e do final da string
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 15,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mínimo de caracteres inaceitáveis %min%.',
                                \Zend\Validator\StringLength::TOO_LONG => 'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));
            
            //input filter para campó de telefone secundario
            $inputFilter->add(array(
                'name' => 'telefone_secundario',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'), #remove xml e html da string
                    array('name' => 'StringTrim'), #remove espaços do início e do final da string
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 15,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mínimo de caracteres inaceitáveis %min%.',
                                \Zend\Validator\StringLength::TOO_LONG => 'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}