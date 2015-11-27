<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler\Context;

use OldTown\Workflow\TransientVars\TransientVarsInterface;
use OldTown\Workflow\Loader\WorkflowDescriptor;


/**
 * Interface ContextInterface
 *
 * @package OldTown\Workflow\ZF2\View\Handler\Context
 */
interface ContextInterface
{
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
