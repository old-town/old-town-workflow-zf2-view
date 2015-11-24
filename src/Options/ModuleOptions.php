<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package OldTown\Workflow\ZF2\View\Options
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $view;

    /** @var ViewOptions[] */
    protected $viewOptions = [];

    /**
     * @return array
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param array $view
     *
     * @return $this
     */
    public function setView(array $view = [])
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @param $viewName
     *
     * @return ViewOptions
     *
     * @throws \OldTown\Workflow\ZF2\View\Options\Exception\InvalidViewNameException
     */
    public function getViewOptions($viewName)
    {
        if (array_key_exists($viewName, $this->viewOptions)) {
            return $this->viewOptions[$viewName];
        }

        $viewConfig = $this->getView();

        if (!array_key_exists($viewName, $viewConfig)) {
            $errMsg = sprintf('Invalid view name %s', $viewName);
            throw new Exception\InvalidViewNameException($errMsg);
        }

        $this->viewOptions[$viewName] = new ViewOptions($viewConfig[$viewName]);

        return $this->viewOptions[$viewName];
    }


}
