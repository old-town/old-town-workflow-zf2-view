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
    protected $listener;

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
    public function getListener()
    {
        return $this->listener;
    }

    /**
     * @param string $listener
     *
     * @return $this
     */
    public function setListener($listener)
    {
        $this->listener = $listener;

        return $this;
    }
}
