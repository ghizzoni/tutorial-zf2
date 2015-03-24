<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Contato\Model\ContatoTable as ModelContato;
use Contato\Form\ContatoForm;
// import ModelContato
use Contato\Model\Contato;

class ContatosController extends AbstractActionController
{
    protected $contatoTable;
    
    // GET /contatos
    public function indexAction()
    {
        // localizar adapter do banco
        //$adapter = $this->getServiceLocator()->get('AdapterDb');
        
        // model ContatoTable instanciado
        //$modelContato = new ModelContato($adapter); // alias para ContatoTable
        
        //enviar para o viewmodel o array com key contatos e value com todos os contatos
        //return new ViewModel(array('contatos' => $modelContato->fetchAll()));
        //return new ViewModel(['contatos' => $this->getContatoTable()->fetchAll()]);
        //
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual' => $this->params()->fromQuery('pagina', 1),
            'itens_pagina' => $this->params()->fromQuery('itens_pagina', 4),
            'coluna_nome' => $this->params()->fromQuery('coluna_nome', 'nome'),
            'coluna_sort' => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search' => $this->params()->fromQuery('search', null),
        ];
        
        // configurar método de paginação
        $paginacao = $this->getContatoTable()->fetchPaginator(
            $paramsUrl['pagina_atual'],
            $paramsUrl['itens_pagina'],
            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            $paramsUrl['search'],
            4
        );
        
        return new ViewModel(['contatos' => $paginacao] + $paramsUrl);
    }
    
    // GET /contatos/novo
    public function novoAction()
    {
        return ['formContato' => new ContatoForm()];
    }
    
    // POST /contatos/adicionar
    public function adicionarAction()
    {
        // obtem a requisição
        $request = $this->getRequest();
        
        // verifica s a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            //$postData = $request->getPost()->toArray();
            //$formularioValido = true;
            
            // instancia o formulario
            $form = new ContatoForm();
            // instancia model contato com regras de filtros e validações
            $modelContato = new Contato();
            // passa para o objeto formulário as regras de filtros e validações
            // contidas na entity contatos
            $form->setInputFilter($modelContato->getInputFilter());
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());
            
            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os dados a tabela no banco
                // 1 - popular model com valores do fomulário
                $modelContato->exchangeArray($form->getData());
                // 2 - persistir dados do model para banco de dados
                $this->getContatoTable()->save($modelContato);
                
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso!");
                
                // redireciona para action index no controller contatos
                return $this->redirect()->toRoute('contatos');
            } else {
                // renderiza para action novo com objeto form populado
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                                ->setVariable('formContato', $form)
                                ->setTemplate('contato/contatos/novo');
            }
        }
    }
    
    // GET /contatos/detalhes/id
    public function detalhesAction()
    {
        // filtra id passada pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        
        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Contato não encontrado");
            
            // redireciona para action index
            return $this->redirect()->toRoute('contatos');
        }
        
        // aqui vai a lógica para pegar os dados referentes ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formulário com dados preenchidos
        /*$form = array(
            'nome' => 'Igor Rocha',
            'telefone_principal' => '(085) 8585-8585',
            'telefone_secundario' => '(085) 8585-8585',
            'data_criacao' => '02/03/2013',
            'data_atualizacao' => '02/03/2013',
        );*/
        
        // localizar adapter do banco
        //$adapter = $this->getServiceLocator()->get('AdapterDb');
        
        // model contatotable instanciado
        //$modelContato = new ModelContato($adapter); // alias para ContatoTable
        try {
            //$form = (array) $modelContato->find($id);
            //$form = (array) $this->getContatoTable()->find($id);
            $contato = $this->getContatoTable()->find($id);
        } catch (Exception $ex) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            
            // redireciona para o action index
            return $this->redirect()->toRoute('contatos');
        }
        // dados enviados para detalhes.phtml
        //return array('id' => $id, 'form' => $form);
        return ['contato' => $contato];
    }
    
    // GET /contatos/editar/id
    public function editarAction()
    {
        // filtra id passando pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        
        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adiciona mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encontrado");
            
            // redireciona para action index
            return $this->redirect()->toRoute('contatos');
        }
        
        // aqui vai a lógica para pegar os dados referentes ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        
        // formulário com dados preenchidos
        /*$form = array(
            'nome' => 'Igor Rocha',
            'telefone_principal' => '(085) 8585-8585',
            'telefone_secundario' => '(085) 8585-8585',
        );*/
        
        // localizar adapter do banco
        //$adapter = $this->getServiceLocator()->get('AdapterDb');
        
        // model contatotable instanciado
        //$modelContato = new ModelContato($adapter); // alias para contatotable
        try {
            //$form = (array) $modelContato->find($id);
            //$form = (array) $this->getContatoTable()->find($id);
            // variável com objeto contato localizado
            $contato = (array) $this->getContatoTable()->find($id);
        } catch (Exception $ex) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            
            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }
        
        // dados enviados para editar.phtml
        //return array('id' => $id, 'form' => $form);
        
        // objeto form contato vazio
        $form = new ContatoForm();
        // popula objeto form contato com objeto model contato
        $form->setData($contato);
        //dados enviados para editar.phtml
        return ['formContato' => $form];
    }
    
    // PUT /contatos/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();
        
        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            //$postData = $request->getPost()->toArray();
            //$formularioValido = true;
            
            // instancia formulário
            $form = new ContatoForm();
            // instancia model contato com regras de filtros e validações
            $modelContato = new Contato();
            // passa para o objeto formulário as regras de filtros e validações
            // contidas na entity contato
            $form->setInputFilter($modelContato->getInputFilter());
            // passa para o objeto formulário os dados vindos da submissão
            $form->setData($request->getPost());
            
            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atgualizar os dados a tabela no banco
                // 1 - popular model com valores do formulário
                $modelContato->exchangeArray($form->getData());
                // 2 - atualizar dados do model para bancos de dados
                $this->getContatoTable()->update($modelContato);
                
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato editado com sucesso");
                
                // redirecionar para action detalhes
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $modelContato->id));
            } else {
                // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto foram populado
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                                ->setVariable('formContato', $form)
                                ->setTemplate('contato/contatos/editar');
            }
        }
    }
    
    // DELETE /contatos/deletar/id
    public function deletarAction()
    {
        // filtra id passado pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        
        // se a id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage('Contato não encontrado');
        } else {
            // aqui vai a lógica para deletar o contato no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta contato
            
            // adicionar mensagem de sucesso
            //$this->flashMessenger()->addSuccessMessage("Contato de ID $id deletado com sucesso");
            
            // aqui vai a lógica para deletar o contato no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta contato
            $this->getContatoTable()->delete($id);
            
            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Contato de ID $id deletado com sucesso!");
        }
        
        // redirecionar para action index
        return $this->redirect()->toRoute('contatos');
    }
    
    /**
     * Método privado para obter instância do Model ContatoTable
     * 
     * @return ContatoTable
     */
    private function getContatoTable()
    {
        // localizar adapter do banco
        //$adapter = $this->getServiceLocator()->get('AdapterDb');
        
        // return model ContatoTable
        //return new ModelContato($adapter); // alias para ContatoTable
        
        // obter instancia tablegateway configurada
        //$tableGateway = $this->getServiceLocator()->get('ContatoTableGateway');
        
        // return model ContatoTable
        //return new ModelContato($tableGateway); // alias para ContatoTable
        if (!$this->contatoTable) {
            $this->contatoTable = $this->getServiceLocator()->get('ModeContato');
        }
        return $this->contatoTable;
    }
}