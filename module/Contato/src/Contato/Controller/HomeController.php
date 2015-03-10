<?php
/**
 * namespace de localização do nosso controller
 */
namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter as Adaptador;
use Zend\Db\Sql\Sql;

class HomeController extends AbstractActionController
{
    /**
     * action index
     * @return ZendViewModelViewModel
     */
    public function indexAction()
    {
        /**
         * função anônima para var_dump estilizado
         */
        $myVarDump = function($nome_linha = "Nome da Linha", $data = null, $caracter = ' - '){
            echo str_repeat($caracter, 100) . '<br />' . ucwords($nome_linha) . '<pre><br />';
            var_dump($data);
            echo '<pre>' . str_repeat($caracter, 100) . '<br /><br />';
        };
        
        /**
         * coinexão com banco
         */
        /*$adapter = new Adaptador(array( // alias use Zend\Db\Adapter\Adapter as Adaptador
            'driver' => 'Pdo_mysql',
            'database' => 'agenda_contatos',
            'username' => 'root',
            'password' => 'ricjun'
        ));*/
        $adapter = $this->getServiceLocator()->get('AdapterDb');
        
        /**
         * obter nome do schema do nosso banco
         */
        $myVarDump(
            "Nome Schema",
            $adapter->getCurrentSchema()
        );
        
        /**
         * contar quantidade de elementos da nossa tabela
         */
        $myVarDump(
            "Quantidade elementos tabela contatos",
            $adapter->query("Select * from contatos")->execute()->count()
        );
        
        /**
         * montar objeto sql e executar
         */
        $sql = new Sql($adapter); // use Zend\Db\Sql\Sql
        $select = $sql->select()->from('contatos');
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSql = $statement->execute();
        $myVarDump(
            "Object Sql com Select executado",
            $resultSql
        );
        
        /**
         * mostrar objeto resultset com objeto sql e mostrar resultado em array
         */
        $resultSet = new \Zend\Db\ResultSet\ResultSet;
        $resultSet->initialize($resultSql);
        $myVarDump(
            "Resultado do Objeto SQL para Array ",
            $resultSet->toArray()
        );
        die();
    }
    
    /**
     * action sobre
     * @return \Zend\View\Model\ViewModel
     */
    public function sobreAction()
    {
        return new ViewModel();
    }
}

