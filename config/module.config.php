<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View;


use OldTown\Workflow\ZF2\View\Options\ModuleOptions;
use OldTown\Workflow\ZF2\View\Options\ModuleOptionsFactory;
use OldTown\Workflow\ZF2\View\Listener\RenderWorkflowResult;
use \OldTown\Workflow\ZF2\View\Listener\RenderWorkflowResultFactory;

return [
    'service_manager' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class,
            RenderWorkflowResult::class => RenderWorkflowResultFactory::class
        ],
        'abstract_factories' => [

        ]
    ]
];