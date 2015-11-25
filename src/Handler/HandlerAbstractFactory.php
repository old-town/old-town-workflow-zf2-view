<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler;


use OldTown\Workflow\ZF2\View\Options\ModuleOptions;
use Zend\Mvc\Application;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class HandlerAbstractFactory
 *
 * @package OldTown\Workflow\ZF2\View\Handler
 */
class HandlerAbstractFactory implements AbstractFactoryInterface
{

    /**
     * @var string
     */
    protected static $serviceNamePattern = 'workflow.view.handler.';

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return bool|void
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $flag = 0 === strpos($requestedName, static::$serviceNamePattern) && strlen($requestedName) > strlen(static::$serviceNamePattern);
        return $flag;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return mixed|void
     * @throws \OldTown\Workflow\ZF2\View\Handler\Exception\FactoryException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $viewName = substr($requestedName, strlen(static::$serviceNamePattern));
        try {
            $appServiceManager = null;
            if ($serviceLocator instanceof AbstractPluginManager) {
                $appServiceManager = $serviceLocator->getServiceLocator();
            }

            if (null === $appServiceManager) {
                $errMsg = 'Error create app service locator';
                throw new Exception\RuntimeException($errMsg);
            }

            /** @var ModuleOptions $moduleOptions */
            $moduleOptions = $appServiceManager->get(ModuleOptions::class);
            $viewOptions = $moduleOptions->getViewOptions($viewName);

            $handlerName = $viewOptions->getHandler();
            if (null === $handlerName) {
                $handlerName = Manager::DEFAULT_HANDLER;
            }

            /** @var Application $app */
            $app = $appServiceManager->get('application');
            $mvcEvent = $app->getMvcEvent();
            $handlerOptions = [
                'template' => $viewOptions->getTemplate(),
                'mvcEvent' => $mvcEvent
            ];

            $handler = $serviceLocator->get($handlerName, $handlerOptions);

        } catch (\Exception $e) {
            throw new Exception\FactoryException($e->getMessage(), $e->getCode(), $e);
        }

        return $handler;
    }

    /**
     * Получение имени сервиса, по имени view
     *
     * @param $viewName
     *
     * @return string
     */
    public static function buildServiceName($viewName)
    {
        return static::$serviceNamePattern . $viewName;
    }
}
