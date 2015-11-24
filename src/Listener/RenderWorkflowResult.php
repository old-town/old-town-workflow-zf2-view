<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use OldTown\Workflow\ZF2\Event\WorkflowEvent;
use OldTown\Workflow\ZF2\View\Options\ModuleOptions;
use OldTown\Workflow\ZF2\View\Handler\Manager as HandlerManager;


/**
 * Class RenderWorkflowResult
 *
 * @package OldTown\Workflow\ZF2\View\Listener
 */
class RenderWorkflowResult extends AbstractListenerAggregate
{
    /**
     * @var string
     */
    const MODULE_OPTIONS = 'moduleOptions';
    /**
     * @var string
     */
    const HANDLER_MANAGER = 'handlerManager';
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var HandlerManager
     */
    protected $handlerManager;

    /**
     * @param array $options
     *
     * @throws  \OldTown\Workflow\ZF2\View\Listener\Exception\InvalidArgumentException
     */
    public function __construct(array $options = [])
    {
        $this->init($options);
    }

    /**
     * @param array $options
     *
     * @throws  \OldTown\Workflow\ZF2\View\Listener\Exception\InvalidArgumentException
     */
    protected function init(array $options = [])
    {
        if (!array_key_exists(static::MODULE_OPTIONS, $options)) {
            $errMsg = sprintf('option %s not found', static::MODULE_OPTIONS);
            throw new Exception\InvalidArgumentException($errMsg);
        }
        $this->setModuleOptions($options[static::MODULE_OPTIONS]);

        if (!array_key_exists(static::HANDLER_MANAGER, $options)) {
            $errMsg = sprintf('option %s not found', static::HANDLER_MANAGER);
            throw new Exception\InvalidArgumentException($errMsg);
        }
        $this->setHandlerManager($options[static::HANDLER_MANAGER]);
    }

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(WorkflowEvent::EVENT_RENDER, [$this, 'renderWorkflowResult'], -80);
    }

    /**
     * Обработчик на котый делегирован функционал отображения результатов работы workflow
     *
     * @param WorkflowEvent $event
     *
     * @throws \OldTown\Workflow\ZF2\View\Options\Exception\InvalidViewNameException
     * @throws \OldTown\Workflow\ZF2\View\Listener\Exception\InvalidViewNameException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Zend\ServiceManager\Exception\ServiceNotCreatedException
     * @throws \Zend\ServiceManager\Exception\RuntimeException
     *
     * @return mixed
     */
    public function renderWorkflowResult(WorkflowEvent $event)
    {
        $viewName = $event->getViewName();
        if (null === $viewName) {
            $errMsg = 'viewName not found';
            throw new Exception\InvalidViewNameException($errMsg);
        }
        $viewOptions = $this->getModuleOptions()->getViewOptions($viewName);

        $handlerName = $viewOptions->getHandler();
        if (null === $handlerName) {
            $handlerName = HandlerManager::DEFAULT_HANDLER;
        }

        $handler = $this->getHandlerManager()->get($handlerName);

        $viewData = $handler->dispatch();

        return $viewData;
    }

    /**
     * @return ModuleOptions
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * @param ModuleOptions $moduleOptions
     *
     * @return $this
     */
    public function setModuleOptions(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;

        return $this;
    }

    /**
     * @return HandlerManager
     */
    public function getHandlerManager()
    {
        return $this->handlerManager;
    }

    /**
     * @param HandlerManager $handlerManager
     *
     * @return $this
     */
    public function setHandlerManager(HandlerManager $handlerManager)
    {
        $this->handlerManager = $handlerManager;

        return $this;
    }



}
