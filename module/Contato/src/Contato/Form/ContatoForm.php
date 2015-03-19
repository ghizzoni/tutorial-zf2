<?php

/**
 * namespace de localização do nosso formulário
 */
namespace Contato\Form;

use Zend\Captcha;
use Zend\Form\Form;
use Zend\Form\Element;

class ContatoForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        //config form attributes
        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));
        
        // elemento do tipo hidden
        $this->add(array(
            'type' => 'Hidden', // ou 'Zend\Form\Element\Hidden'
            'name' => 'id',
        ));
        
        // elemento do tipo text
        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputNome',
                'placeholder' => 'Nome Completo',
            ),
        ));
        
        // elemento do tipo texto
        $this->add(
            (new Element\Text())
                ->setName('telefone_principal')
                ->setAttributes(
                    [
                        'class' => 'form-control',
                        'id' => 'inputTelefonePrincipal',
                        'placeholder' => 'Digite seu telefone principal',
                    ]
                )
        );
        
        // elemento do tipo text
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'telefone_secundario',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputTelefoneSecundario',
                'placeHolder' => 'Digite seu telefone secundario (optional)',
            ),
        ));
        
        
        // elemento do tipo captcha para evitar ataque de robos
        $this->add(
            (new Element\Captcha())
                ->setName('captcha')
                ->setOptions(array(
                    'captcha' => (new Captcha\Figlet(array(
                        'wordLen' => 12,
                        'timeout' => 300,
                        'outputWidth' => '500',
                        'font' => 'data/fonts/banner3.flf',
                    )))->setMessage("Campo faltando ou digitado incorretamente')")
                ))
                ->setAttributes([
                    'class' => 'form-control',
                    'id' => 'inputCaptcha',
                    'placeHolder' => 'Digite a palavra acima, aqui, para prosseguir'
                ])
        );
        
        // elemento para evitar ataques cross-site request forgery
        $this->add(new Element\Csrf('security'));
    }
}