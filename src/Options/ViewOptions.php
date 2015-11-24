<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ViewOptions
 *
 * @package OldTown\Workflow\ZF2\View\Options
 */
class ViewOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $handler;

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param string $handler
     *
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }
}
