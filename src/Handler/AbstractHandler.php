<?php
/**
 * @link https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View\Handler;

use OldTown\Workflow\ZF2\View\Handler\Context\ContextEventInterface;
use OldTown\Workflow\ZF2\View\Handler\Context\ContextInterface;
use OldTown\Workflow\ZF2\View\Handler\Context\HandlerContext;
use Traversable;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Stdlib\ArrayUtils;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\ModelInterface;
use Zend\EventManager\EventInterface;

/**
 * Class AbstractHandler
 *
 * @package OldTown\Workflow\ZF2\View\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    use EventManagerAwareTrait;

    /**
     *
     * @var string
     */
    const CAPTURE_TO_DEFAULT = 'workflowContent';

    /**
     * @var string
     */
    protected $template;

    /**
     * @var MvcEvent
     */
    protected $mvcEvent;

    /**
     * @var ViewModel
     */
    protected $workflowViewModel;

    /**
     * @var string
     */
    protected $captureTo = self::CAPTURE_TO_DEFAULT;

    /**
     * @param array|Traversable $options
     *
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @throws \OldTown\Workflow\ZF2\View\Handler\Exception\InvalidArgumentException
     */
    public function __construct($options = null)
    {
        $this->init($options);
    }

    /**
     * @param array $options
     *
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @throws \OldTown\Workflow\ZF2\View\Handler\Exception\InvalidArgumentException
     */
    protected function init($options = null)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (null === $options) {
            $options = [];
        } elseif (!is_array($options)) {
            $errMsg = sprintf('%s  expects an array or Traversable config', __METHOD__);
            throw new Exception\InvalidArgumentException($errMsg);
        }

        if (array_key_exists('template', $options) && null !== $options['template']) {
            $this->setTemplate($options['template']);
        }

        if (!array_key_exists('mvcEvent', $options) || null === $options['mvcEvent']) {
            $errMsg = 'MvcEvent not found';
            throw new Exception\InvalidArgumentException($errMsg);
        }
        $this->setMvcEvent($options['mvcEvent']);

        if (array_key_exists('captureTo', $options)  && null !== $options['captureTo']) {
            $this->setCaptureTo($options['captureTo']);
        }
    }

    /**
     * Установка обработчиков по умолчанию
     */
    public function attachDefaultListeners()
    {
        $this->getEventManager()->attach(ContextEventInterface::EVENT_BOOTSTRAP, [$this, 'bootstrap'], -100);
        $this->getEventManager()->attach(ContextEventInterface::EVENT_TEMPLATE_RESOLVE, [$this, 'templateResolve'], -100);
        $this->getEventManager()->attach(ContextEventInterface::EVENT_DISPATCH, [$this, 'dispatch'], -100);
    }


    /**
     * Настройка хендлера
     *
     * @param ContextInterface $context
     */
    public function bootstrap(ContextInterface $context)
    {
    }

    /**
     * Установка нового шаблона
     *
     * @param ContextInterface $context
     */
    public function templateResolve(ContextInterface $context)
    {
        $template = $this->getTemplate();
        if ($template) {
            $this->getWorkflowViewModel()->setTemplate($template);
        }
    }

    /**
     * Пред обработка данных
     *
     * @param ContextInterface $context
     *
     * @return mixed
     */
    public function dispatch(ContextInterface $context)
    {
    }

    /**
     * @param ContextInterface $context
     *
     * @return void
     */
    public function run(ContextInterface $context)
    {
        if ($context instanceof EventInterface) {
            $event = $context;
        } else {
            $event = $this->createEventByContext($context);
        }

        $this->getEventManager()->trigger(ContextEventInterface::EVENT_BOOTSTRAP, $this, $event);
        $this->getEventManager()->trigger(ContextEventInterface::EVENT_TEMPLATE_RESOLVE, $this, $event);
        $resultDispatchHandler = $this->getEventManager()->trigger(ContextEventInterface::EVENT_DISPATCH, $this, $event);
        $resultDispatch = $resultDispatchHandler->last();

        if (null === $resultDispatch) {
            $resultDispatch = [];
        }
        $workflowViewMode = $this->getWorkflowViewModel();
        $this->populateViewModel($resultDispatch, $workflowViewMode);

        $viewModel = $this->getMvcEvent()->getViewModel();
        $viewModel->addChild($this->getWorkflowViewModel());
    }

    /**
     * @param ContextInterface $context
     *
     * @return ContextEventInterface
     */
    protected function createEventByContext(ContextInterface $context)
    {
        $event = new HandlerContext();

        $event->setWorkflow($context->getWorkflow());
        $event->setTransientVars($context->getTransientVars());

        return $event;
    }

    /**
     * Populate the view model returned by the AcceptableViewModelSelector from the result
     *
     * If the result is a ViewModel, we "re-cast" it by copying over all
     * values/settings/etc from the original.
     *
     * If the result is an array, we pass those values as the view model variables.
     *
     * @param  array|ViewModel $result
     * @param  ModelInterface $viewModel
     */
    protected function populateViewModel($result, ModelInterface $viewModel)
    {
        if ($result instanceof ViewModel) {
            // "Re-cast" content-negotiation view models to the view model type
            // selected by the AcceptableViewModelSelector

            $viewModel->setVariables($result->getVariables());
            $viewModel->setTemplate($result->getTemplate());
            $viewModel->setOptions($result->getOptions());
            $viewModel->setCaptureTo($result->captureTo());
            $viewModel->setTerminal($result->terminate());
            $viewModel->setAppend($result->isAppend());
            if ($result->hasChildren()) {
                foreach ($result->getChildren() as $child) {
                    $viewModel->addChild($child);
                }
            }

            //$e->setResult($viewModel);
            return;
        }

        // At this point, the result is an array; use it to populate the view
        // model variables
        $viewModel->setVariables($result);
    }


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
     * @return MvcEvent
     */
    public function getMvcEvent()
    {
        return $this->mvcEvent;
    }

    /**
     * @param MvcEvent $mvcEvent
     *
     * @return $this
     */
    public function setMvcEvent(MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;

        return $this;
    }

    /**
     * @return string
     */
    public function getCaptureTo()
    {
        return $this->captureTo;
    }

    /**
     * @param string $captureTo
     *
     * @return $this
     */
    public function setCaptureTo($captureTo)
    {
        $this->captureTo = $captureTo;

        return $this;
    }

    /**
     * @return ViewModel
     */
    public function getWorkflowViewModel()
    {
        if (null !== $this->workflowViewModel) {
            return $this->workflowViewModel;
        }
        $this->workflowViewModel = new ViewModel();
        $this->workflowViewModel->setCaptureTo($this->getCaptureTo());
        $this->workflowViewModel->setAppend(true);

        return $this->workflowViewModel;
    }

    /**
     * @param ViewModel $workflowViewModel
     *
     * @return $this
     */
    public function setWorkflowViewModel(ViewModel $workflowViewModel)
    {
        $this->workflowViewModel = $workflowViewModel;

        return $this;
    }
}
