<?php
$base_path = dirname($_SERVER['PHP_SELF']);
$is_admin = strpos($base_path, '/admin') !== false;
$logo_path = $is_admin ? '../assets/iaa_logo.png' : 'assets/iaa_logo.png';
$full_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $logo_path;

if (!file_exists($full_path)) {
    error_log("Logo file not found: " . $full_path);
}
?>
<img src="<?php echo htmlspecialchars($logo_path); ?>" alt="IAA Logo" class="iaa-logo"> 