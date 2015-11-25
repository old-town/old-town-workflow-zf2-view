<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package OldTown\Workflow\ZF2\View\Handler
 *
 * @method HandlerInterface get($name, $options = array(), $usePeeringServiceManagers = true)
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     */
    const DEFAULT_HANDLER = 'default';

    /**
     * @param mixed $plugin
     *
     * @throws \OldTown\Workflow\ZF2\View\Handler\Exception\InvalidHandlerException
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof HandlerInterface) {
            $errMsg = sprintf('Handler not implement %s', HandlerInterface::class);
            throw new Exception\InvalidHandlerException($errMsg);
        }
    }
}
