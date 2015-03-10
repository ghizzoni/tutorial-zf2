<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Contato\Model\ContatoTable as ModelContato;

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
        return new ViewModel(['contatos' => $this->getContatoTable()->fetchAll()]);
    }
    
    // GET /contatos/novo
    public function novoAction()
    {
        
    }
    
    // POST /contatos/adicionar
    public function adicionarAction()
    {
        // obtem a requisição
        $request = $this->getRequest();
        
        // verifica s a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;
            
            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                // aqui vai a lógica para adicionar os dados a tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                // 2 - inserir dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso!");
                
                // redireciona para action index no controller contatos
                return $this->redirect()->toRoute('contatos');
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao criar contato");
                
                // redirecionar para action novo no controller contatos
                return $this->redirect()->toRoute('contatos', array('action' => 'novo'));
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
            $form = (array) $this->getContatoTable()->find($id);
        } catch (Exception $ex) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            
            // redireciona para o action index
            return $this->redirect()->toRoute('contatos');
        }
        // dados enviados para detalhes.phtml
        return array('id' => $id, 'form' => $form);
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
            $form = (array) $this->getContatoTable()->find($id);
        } catch (Exception $ex) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            
            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }
        
        // dados enviados para editar.phtml
        return array('id' => $id, 'form' => $form);
    }
    
    // PUT /contatos/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();
        
        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;
            
            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                // aqui vai a lógica para editar os dados a tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela atualização
                // 2 - editar dados no banco pelo model
                
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato editado com sucesso");
                
                // redireciona para action detalhes
                return $this->redirect()->toRoute('contatos', ['action' => 'detalhes', 'id' => $postData['id'],]);
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage('Erro ao editar o contato');
                
                // redirecionar para action editar
                return $this->redirect()->toRoute('contatos', ['action' => 'editar', 'id' => $postData['id'],]);
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
            $this->flashMessenger()->addSuccessMessage("Contato de ID $id deletado com sucesso");
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