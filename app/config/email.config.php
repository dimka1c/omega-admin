<?php

$mailConfig = [
    'host' => '{imap.gmail.com:993/imap/ssl}INBOX',
    'username' => 'omega.auto.dnepr@gmail.com',
    'password' => 'pop188022ii',
    'patternSubj' => '#^ml/[0-3]{1}[0-9]{1}_[0-1]{1}[0-9]{1}_[2]{1}[0]{1}[0-9]{1}[0-9]{1}/create#i',
    'accessUser' => [
        'dima@udt.dp.ua',
        'turchin.vladimir@omega-auto.biz',
        'eremtsov.maksim@omega-auto.biz',
    ],
    'files' => [
        'ATTACH' => '/public/files/uploads',
        'CSV' => '/public/files/csv',
        'ML' => '/public/files/ml',
        'EDIT' => '/public/files/edit',
    ]
];

return $mailConfig;