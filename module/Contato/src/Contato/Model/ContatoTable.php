<?php

namespace Contato\Model;

//use Zend\Db\Adapter\Adapter;
//use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ContatoTable
{
    protected $tableGateway;
    
    /**
     * Construtor com dependência do Adapter do Banco
     * 
     * @param Adapter $adapter
     */
    //public function __construct(Adapter $adapter)
    public function __construct(TableGateway $tableGateway)
    {
        /*$resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Contato());
        
        $this->tableGateway = new TableGateway('contatos', $adapter, null, $resultSetPrototype);*/
        
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * Recuperar todos os elementos da tabela contatos
     * 
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    /**
     * Localizar linha esecífica pelo id da tabela contatos
     * 
     * @param type $id
     * @return ModelContato
     * @throws Exception
     */
    public function find($id1)
    {
        $id = (int) $id1;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Não foi encontrado contato de id = {$id}");
        }
        
        return $row;
    }
    
    /**
     * inserir um novo contato
     * 
     * @param Contato\Model\Contato $contato
     * @return 1/0
     */
    public function save(Contato $contato)
    {
        $timeNow = new \DateTime();
        
        $data = [
            'nome' => $contato->nome,
            'telefone_principal' => $contato->telefone_principal,
            'telefone_secundario' => $contato->telefone_secundario,
            'data_criacao' => $timeNow->format('Y-m-d H:i:s'),
            'data_atualizacao' => $timeNow->format('Y-m-d H:i:s'),
        ];
        
        return $this->tableGateway->insert($data);
    }
    
    /**
     * Atualizar um contato existente
     * 
     * @param Contato\Model\Contato $contato
     * @throws Exception
     */
    public function update(Contato $contato)
    {
        $timeNow = new \DateTime();
        
        $data = [
            'nome' => $contato->nome,
            'telefone_principal' => $contato->telefone_principal,
            'telefone_secundario' => $contato->telefone_secundario,
            'data_atualizacao' => $timeNow->format('Y-m-d H:i:s'),
        ];
        
        $id = (int) $contato->id;
        if ($this->find($id)) {
            $this->tableGateway->update($data, array('id' => $id));
        } else {
            throw new Exception("Contato #{$id} inexistente.");
        }
    }
    
    /**
     * Deletar um contato existente
     * 
     * @param type $id
     */
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}