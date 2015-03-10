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
}