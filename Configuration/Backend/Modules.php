<?php

/**
 * Definitions for modules provided by EXT:alm_clearlog
 */
return [
    'web_alm_clearlog' => [
        'position' => ['after' => 'web_info'],
        'access' => 'user',
        'extensionName' => 'AlmClearlog',
        'iconIdentifier' => 'module_alm_clearlog',
        'labels' => 'LLL:EXT:alm_clearlog/Resources/Private/Language/locallang.xlf',
        'controllerActions' => [
            \Alm\AlmClearlog\Controller\ClearlogModuleController::class => [
                'index', 'clearTable', 'clearAll',
            ],
        ],
    ],
];