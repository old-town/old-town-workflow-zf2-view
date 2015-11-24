<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use OldTown\Workflow\ZF2\View\Options\ModuleOptions;

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
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        $options = [
            'moduleOptions' => $moduleOptions
        ];

        $service = new RenderWorkflowResult($options);

        return $service;
    }
}
