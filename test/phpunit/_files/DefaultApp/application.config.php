<?php

use \OldTown\Workflow\ZF2\View\PhpUnit\TestData\TestPaths;

return [
    'modules' => [
        'OldTown\\Workflow\\ZF2\\View'
    ],
    'module_listener_options' => [
        'module_paths' => [
            'OldTown\\Workflow\\ZF2\\View' => TestPaths::getPathToModule()
        ],
        'config_glob_paths' => []
    ]
];