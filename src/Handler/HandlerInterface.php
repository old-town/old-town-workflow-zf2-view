<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler;

use \OldTown\Workflow\ZF2\View\Handler\Context\ContextInterface;
use Zend\View\Model\ModelInterface;

/**
 * Interface HandlerInterface
 *
 * @package OldTown\Workflow\ZF2\View\Handler
 */
interface HandlerInterface
{
    /**
     * @param ContextInterface $context
     *
     * @return ModelInterface
     */
    public function run(ContextInterface $context);

    /**
     * Настройка хендлера
     *
     * @param ContextInterface $context
     */
    public function bootstrap(ContextInterface $context);

    /**
     * Установка нового шаблона
     *
     * @param ContextInterface $context
     */
    public function templateResolve(ContextInterface $context);

    /**
     * Пред обработка данных
     *
     * @param ContextInterface $context
     */
    public function dispatch(ContextInterface $context);
}
