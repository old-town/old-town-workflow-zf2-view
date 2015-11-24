<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler;

/**
 * Interface EventBusMessageProviderInterface
 *
 * @package OldTown\Workflow\ZF2\View\Handler
 */
interface EventBusMessageProviderInterface
{
    /**
     * @return array
     */
    public function getWorkflowViewHandlerConfig();
}
