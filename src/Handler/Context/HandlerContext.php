<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler\Context;

use Zend\EventManager\Event;
use OldTown\Workflow\TransientVars\TransientVarsInterface;
use OldTown\Workflow\Loader\WorkflowDescriptor;

/**
 * Class HandlerContext
 *
 * @package OldTown\Workflow\ZF2\View\Handler\Context
 */
class HandlerContext extends Event implements ContextInterface
{
    /**
     * @var TransientVarsInterface
     */
    protected $transientVars;

    /**
     * @var WorkflowDescriptor
     */
    protected $workflow;

    /**
     * @return TransientVarsInterface
     */
    public function getTransientVars()
    {
        return $this->transientVars;
    }

    /**
     * @param TransientVarsInterface $transientVars
     *
     * @return $this
     */
    public function setTransientVars(TransientVarsInterface $transientVars = null)
    {
        $this->transientVars = $transientVars;

        return $this;
    }

    /**
     * @return WorkflowDescriptor
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param WorkflowDescriptor $workflow
     *
     * @return $this
     */
    public function setWorkflow(WorkflowDescriptor $workflow = null)
    {
        $this->workflow = $workflow;

        return $this;
    }



}
