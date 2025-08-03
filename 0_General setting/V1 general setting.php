<?php
ob_start(); // 开启输出缓冲
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
$ip = $_SERVER['REMOTE_ADDR'];
$now = time();

$entry = [
    'path' => $path,
    'time' => date('Y-m-d H:i:s'),
    'ip'   => $ip,
    'ua'   => $_SERVER['HTTP_USER_AGENT']
];

$data = file_exists($visitFile) ? json_decode(file_get_contents($visitFile), true) : [];
$allowSave = true;

foreach (array_reverse($data) as $log) {
    if ($log['path'] === $path && $log['ip'] === $ip) {
        $lastTime = strtotime($log['time']);
        if (($now - $lastTime) < 60) {
            $allowSave = false;
        }
        break;
    }
}

if ($allowSave) {
    $data[] = $entry;
    file_put_contents($visitFile, json_encode($data, JSON_PRETTY_PRINT));
}

ob_end_clean(); // 清除并关闭输出缓冲
?>
