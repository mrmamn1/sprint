<?php
require_once 'autoload.php';
$Template = new TemplateEngine('template');
$dir = (System::SuperArrayGet('Acc', 's')['user_id'] > 1) ? 'User' : 'Guest';

if (isset($PageInfo['error']) == true && empty($PageInfo['error']) == false) {
    $PageInfo['content'] = System::GetPage('Output', $PageInfo['error']);
} else {
    $PageInfo['content'] = System::GetPage('Output', $PageInfo['content_file']);
}

echo $Template->render($dir . '/header.html', array_merge($PageInfo));
echo $Template->render($dir . '/navbar.html', array_merge($PageInfo));
echo $Template->render($dir . '/content.html', array_merge($PageInfo));
echo $Template->render($dir . '/footer.html', array_merge($PageInfo));
