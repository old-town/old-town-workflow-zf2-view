<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\View\Options\ModuleOptions;
use OldTown\Workflow\ZF2\View\Handler\Manager;


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
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \OldTown\Workflow\ZF2\View\Listener\Exception\InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);
        $handlerManager = $serviceLocator->get(Manager::class);

        $options = [
            'moduleOptions' => $moduleOptions,
            'handlerManager' => $handlerManager
        ];

        $service = new RenderWorkflowResult($options);

        return $service;
    }
}
