<?php
/**
 * Activity Logger utility class for tracking system activities
 */
class ActivityLogger {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function logActivity($userId, $userType, $action, $details = null) {
        try {
            // Get user information
            $userInfo = $this->getUserInfo($userId, $userType);
            
            // Prepare activity data
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            
            // Insert into audit log
            $sql = "INSERT INTO audit_log (user_id, user_type, action, details, ip_address, user_agent) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("isssss", $userId, $userType, $action, $details, $ipAddress, $userAgent);
            $stmt->execute();
            
            // Update user activity
            $this->updateUserActivity($userId, $userType);
            
            return true;
        } catch (Exception $e) {
            error_log("Activity logging error: " . $e->getMessage());
            return false;
        }
    }
    
    private function getUserInfo($userId, $userType) {
        $table = $userType === 'admin' ? 'admins' : 'students';
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    private function updateUserActivity($userId, $userType) {
        $table = $userType === 'admin' ? 'admins' : 'students';
        $sql = "UPDATE $table 
                SET last_activity = NOW(), 
                    activity_count = activity_count + 1 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
    
    public function getUserActivity($userId, $userType) {
        $table = $userType === 'admin' ? 'admins' : 'students';
        $sql = "SELECT last_activity, activity_count 
                FROM $table 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function getRecentActivities($limit = 50) {
        $sql = "SELECT a.*, s.name as student_name, a.user_type, a.action, a.details, a.ip_address, a.user_agent 
                FROM audit_log a 
                LEFT JOIN students s ON a.user_id = s.id 
                ORDER BY a.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
