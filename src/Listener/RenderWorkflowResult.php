<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use OldTown\Workflow\ZF2\Event\WorkflowEvent;

/**
 * Class RenderWorkflowResult
 *
 * @package OldTown\Workflow\ZF2\View\Listener
 */
class RenderWorkflowResult extends AbstractListenerAggregate
{
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
     */
    public function renderWorkflowResult()
    {
    }
}
