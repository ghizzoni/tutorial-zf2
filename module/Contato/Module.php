<?php
namespace Contato;

use Contato\Model\Contato;
use Contato\Model\ContatoTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    /**
     * Register View Helper
     */
    public function getViewHelperConfig()
    {
        return array(
            # registrar View Helper com injeção de dependência
            'factories' => array(
                'menuAtivo' => function($sm) {
                    return new View\Helper\MenuAtivo($sm->getServiceLocator()->get('Request'));
                },
                'message' => function($sm) {
                    return new View\Helper\Message($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashMessenger'));
                }
            ),
            'invokables' => array(
                'filter' => 'Contato\View\Helper\ContatoFilter'
            )        
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ContatoTableGateway' => function ($sm) {
                    // obter adapter db através do service manager
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    
                    // configurar ResultSet com nosso model Contato
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Contato());
                    
                    // return TableGateway configurado para nosso model Contato
                    return new TableGateway('contatos', $adapter, null, $resultSetPrototype);
                },
                'ModeContato' => function($sm) {
                    // return instancia Model ContatoTable
                    return new ContatoTable($sm->get('ContatoTableGateway'));
                }
            )
        );
    }
}
