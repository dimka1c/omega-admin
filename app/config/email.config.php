<?php

$mailConfig = [
    'host' => '{imap.gmail.com:993/imap/ssl}INBOX',
    'username' => '',
    'password' => '',
    'patternSubj' => '#^ml/[0-3]{1}[0-9]{1}_[0-1]{1}[0-9]{1}_[2]{1}[0]{1}[0-9]{1}[0-9]{1}/create#i',
    'accessUser' => [
        '',
    ],
    'files' => [
        'ATTACH' => '/public/files/uploads',
        'CSV' => '/public/files/csv',
        'ML' => '/public/files/ml',
        'EDIT' => '/public/files/edit',
    ]
];

return $mailConfig;