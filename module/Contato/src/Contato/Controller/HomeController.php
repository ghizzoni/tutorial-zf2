<?php
/**
 * namespace de localização do nosso controller
 */
namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
    /**
     * action index
     * @return ZendViewModelViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}
