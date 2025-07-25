<?php
/**
 * CSRF protection class
 */
class CSRF {
    private static $token_name = '_csrf_token';
    
    /**
     * Generate a CSRF token
     */
    public static function generateToken() {
        if (!isset($_SESSION[self::$token_name])) {
            $_SESSION[self::$token_name] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::$token_name];
    }
    
    /**
     * Validate CSRF token
     */
    public static function validateToken($token) {
        return isset($_SESSION[self::$token_name]) && 
               hash_equals($_SESSION[self::$token_name], $token);
    }
    
    /**
     * Get CSRF token input field for forms
     */
    public static function getTokenField() {
        return '<input type="hidden" name="csrf_token" value="' . 
               htmlspecialchars(self::generateToken()) . '">';
    }
}
?>
