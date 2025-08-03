<?php
date_default_timezone_set('Asia/Taipei');

$logDir = realpath(__DIR__ . '/../V90 visite tracker/logs');
if (!$logDir) {
    $logDir = __DIR__ . '/../V90 visite tracker/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
}
$visitFile = $logDir . '/system_visits.json';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$entry = [
    'path' => $path,
    'time' => date('Y-m-d H:i:s'),
    'ip'   => $_SERVER['REMOTE_ADDR'],
    'ua'   => $_SERVER['HTTP_USER_AGENT']
];

$data = file_exists($visitFile) ? json_decode(file_get_contents($visitFile), true) : [];
$data[] = $entry;

if (file_put_contents($visitFile, json_encode($data, JSON_PRETTY_PRINT))) {
    echo "save ok";
} else {
    echo "save failed";
}
?>
