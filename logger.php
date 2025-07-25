<?php
/**
 * Logger utility class for application logging
 */
class Logger {
    private static $logFile = 'application.log';
    
    public static function log($message, $type = 'INFO') {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$type] $message\n";
        
        // Create log directory if it doesn't exist
        if (!file_exists('logs')) {
            mkdir('logs', 0777, true);
        }
        
        // Write to log file
        file_put_contents('logs/' . self::$logFile, $logMessage, FILE_APPEND);
    }
    
    public static function error($message) {
        self::log($message, 'ERROR');
    }
    
    public static function info($message) {
        self::log($message, 'INFO');
    }
    
    public static function warning($message) {
        self::log($message, 'WARNING');
    }
}
?>
