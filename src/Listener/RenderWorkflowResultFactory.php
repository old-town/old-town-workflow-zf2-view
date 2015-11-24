<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RenderWorkflowResultFactory
 *
 * @package OldTown\Workflow\ZF2\View\Listener
 */
class RenderWorkflowResultFactory implements  FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RenderWorkflowResult
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new RenderWorkflowResult();

        return $service;
    }
}
