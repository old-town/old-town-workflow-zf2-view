<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler\Context;

use Zend\EventManager\EventInterface;

/**
 * Interface ContextInterface
 *
 * @package OldTown\Workflow\ZF2\View\Handler\Context
 */
interface ContextEventInterface extends EventInterface, ContextInterface
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
}
