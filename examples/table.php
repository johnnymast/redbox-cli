<?php
require 'autoload.php';

use Redbox\Cli\Cli as CLI;

try {
    $cli = new CLI;

    $data = [
        [
            'Walter White',
            'Father',
            'Teacher',
        ],
        [
            'Skyler White',
            'Mother',
            'Accountant',
        ],
        [
            'Walter White Jr.',
            'Son',
            'Student',
        ],
    ];

    $data = [
        [
            'name'       => 'Walter White',
            'role'       => 'Father',
            'profession' => 'Teacher',
        ],
        [
            'name'       => 'Skyler White',
            'role'       => 'Mother',
            'profession' => 'Accountant',
        ],
        [
            'name'       => 'Walter White Jr.',
            'role'       => 'Son',
//            'profession' => 'Student',
        ],
    ];

    $cli->table($data);

} catch (\Exception $e) {
    echo "ECeption caucht {$e->getMessage()}\n";
}