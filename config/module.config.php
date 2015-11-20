<?php
/**
 * @link    https://github.com/old-town/workflow-zf2-view
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\Workflow\ZF2\View;


use OldTown\Workflow\ZF2\View\Options\ModuleOptions;
use OldTown\Workflow\ZF2\View\Options\ModuleOptionsFactory;

return [
    'service_manager' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class,
        ],
        'abstract_factories' => [

        ]
    ]
];