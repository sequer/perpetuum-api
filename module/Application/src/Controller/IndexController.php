<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014-2016 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZF\Apigility\Admin\Module as AdminModule;

class IndexController extends AbstractActionController
{
    public function __construct($defaultEntityManager, $perpetuumEntityManager)
    {
        $this->defaultEntityManager = $defaultEntityManager;
        $this->perpetuumEntityManager = $perpetuumEntityManager;
    }

    public function indexAction()
    {
        if (class_exists(AdminModule::class, false)) {
            return $this->redirect()->toRoute('zf-apigility/ui');
        }
        return new ViewModel();
    }

    public function debugAction()
    {
        $entity = new \Onboarding\Entity\Entity();
        $this->perpetuumEntityManager->persist($entity);
        $this->perpetuumEntityManager->flush();

        $entity = new \Application\Entity\Entity();
        $this->defaultEntityManager->persist($entity);
        $this->defaultEntityManager->flush();
    }
}
