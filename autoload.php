<?php
session_start();
date_default_timezone_set("Asia/Riyadh");
require_once 'Includes/System.php';
require_once 'Includes/Database.php';
require_once 'Includes/SQLCommands.php';
require_once 'Includes/TemplateEngine.php';

try {
    Database::init('localhost', 'root', '', 'sprint');
    // echo "تم الاتصال بنجاح";
} catch (Exception $e) {
    die("فشل الاتصال: " . $e->getMessage());
}




if (is_array(System::SuperArrayGet('Acc', 's')) && System::SuperArrayGet('Acc', 's')['user_id'] > 1) {
    // مسجل دخول
    $UserData = System::SuperArrayGet('Acc', 's');
} else {
    // ضيف
    System::SuperArraySet('user_id', '1', 'post');
    $Query_GetUserInfo = SQLCommands::GetUserInfo();
    $UserData = Database::select($Query_GetUserInfo['query'], $Query_GetUserInfo['params'])[0];
    System::SuperArraySet('Acc', $UserData, 's');
}


$permissionIds = explode(', ', $UserData['permission_ids'] ?? '');
$permissionLinks = explode(', ', $UserData['permission_links'] ?? '');
$permissionsMap = [];
// التأكد من أن عدد العناصر متساوٍ في المصفوفتين
if (count($permissionIds) === count($permissionLinks) && count($permissionIds) >= 1) {
    foreach ($permissionIds as $index => $id) {
        $permissionsMap[$id] = $permissionLinks[$index];
    }
} else {
    // معالجة الخطأ إذا كان هناك عدم تطابق
    throw new Exception("عدد أرقام الصلاحيات وروابطها غير متطابق");
}

$current_permission = (isset($_GET['p'])) ? trim($_GET['p']) : 'index';

if (in_array($current_permission, $permissionLinks)) {
    $permissions_json = json_decode($UserData['permissions_json'], true);
    $permissions_json = System::arrayKeysToIds($permissions_json);

    $current_permission_info = $permissions_json[System::convertToCamelCase($current_permission)];
    // System::Print($permissions_json, 0, 1);
    $PageInfo['content_file'] = System::convertToCamelCase($current_permission);
    $PageInfo['title'] = $current_permission_info['title'];
    $PageInfo['description'] = $current_permission_info['description'];
    $PageInfo['keywords'] = $current_permission_info['keywords'];
    $PageInfo['author'] = $current_permission_info['author'];
    $PageInfo['copyright'] = $current_permission_info['copyright'];
    $PageInfo['image'] = $current_permission_info['image'];
    $PageInfo['count_new_notification'] = '0';
    $PageInfo['count_new_messages'] = '0';
    $PageInfo['year'] = date("Y");
} else {
    // لا تملك صلاحية 
    $PageInfo['error'] = 'Error404';
    $PageInfo['title'] = 'Error404';
    $PageInfo['description'] = '';
    $PageInfo['keywords'] = '';
    $PageInfo['author'] = '';
    $PageInfo['copyright'] = '';
    $PageInfo['count_new_notification'] = '0';
    $PageInfo['count_new_messages'] = '0';
    $PageInfo['year'] = date("Y");
}



##