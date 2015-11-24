<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View;


use OldTown\Workflow\ZF2\View\Options\ModuleOptions;
use OldTown\Workflow\ZF2\View\Options\ModuleOptionsFactory;
use OldTown\Workflow\ZF2\View\Listener\RenderWorkflowResult;
use OldTown\Workflow\ZF2\View\Listener\RenderWorkflowResultFactory;
use OldTown\Workflow\ZF2\View\Handler\Manager;
use OldTown\Workflow\ZF2\View\Handler\ManagerFactory;
use OldTown\Workflow\ZF2\View\Handler\DefaultHandler;


return [
    'service_manager'           => [
        'factories'          => [
            ModuleOptions::class        => ModuleOptionsFactory::class,
            RenderWorkflowResult::class => RenderWorkflowResultFactory::class,
            Manager::class              => ManagerFactory::class
        ],
        'abstract_factories' => [

        ]
    ],
    'workflow_zf2_view_handler' => [
        'factories'          => [],
        'invokables'         => [
            DefaultHandler::class => DefaultHandler::class
        ],
        'abstract_factories' => [],
        'aliases'            => [
            'default' => DefaultHandler::class
        ]
    ],
    'workflow_zf2_view'         => [
        'view' => [

        ]
    ]
];