<?php
namespace App\Cms\helpers;

class Logger
{
    private const LOG_FILE = "debug.log";

    public function logToFile(string $content): void
    {
        $date = date('Y-m-d H:i:s');
        $content = $date . ': ' . $content;
        $logPath = DEBUG_FOLDER . self::LOG_FILE;
        if (!file_exists($logPath)) {
            mkdir(DEBUG_FOLDER, 0777, true);
        }

        file_put_contents($logPath, $content . "\n", FILE_APPEND);
    }
}