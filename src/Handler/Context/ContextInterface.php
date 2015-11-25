<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler\Context;

use OldTown\Workflow\TransientVars\TransientVarsInterface;
use OldTown\Workflow\Loader\WorkflowDescriptor;
use Zend\EventManager\EventInterface;

/**
 * Interface ContextInterface
 *
 * @package OldTown\Workflow\ZF2\View\Handler\Context
 */
interface ContextInterface extends EventInterface
{
    /**
     * Настройка хендлера
     *
     * @var string
     */
    const EVENT_BOOTSTRAP = 'bootstrap';

    /**
     * Настройка шаблона
     *
     * @var string
     */
    const EVENT_TEMPLATE_RESOLVE = 'template.resolve';

    /**
     * Подготовка данных для рендеринга
     *
     * @var string
     */
    const EVENT_DISPATCH = 'dispatch';

    /**
     * @return TransientVarsInterface
     */
    public function getTransientVars();

    /**
     * @param TransientVarsInterface $transientVars
     *
     * @return $this
     */
    public function setTransientVars(TransientVarsInterface $transientVars = null);

    /**
     * @return WorkflowDescriptor
     */
    public function getWorkflow();

    /**
     * @param WorkflowDescriptor $workflow
     *
     * @return $this
     */
    public function setWorkflow(WorkflowDescriptor $workflow = null);
}
