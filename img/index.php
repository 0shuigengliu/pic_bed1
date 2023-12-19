<?php
$img_array = glob(__DIR__ . '/*.{gif,jpg,png,jpeg,webp,bmp}', GLOB_BRACE);

if (count($img_array) === 0) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => '没有找到图片文件。']);
} else {
    $selected_image = $img_array[array_rand($img_array)];

    // 检查客户端是否支持 WebP
    $accept_header = strtolower($_SERVER['HTTP_ACCEPT']);
    $is_webp_supported = strpos($accept_header, 'image/webp') !== false;

    // 根据客户端支持情况选择最合适的 Content-Type
    $content_type = $is_webp_supported ? 'image/webp' : 'image/jpeg';

    header("Content-Type: $content_type");
    header('Content-Disposition: inline; filename="' . basename($selected_image) . '"');

    // 直接输出文件路径，而不是读取和输出文件内容
    readfile($selected_image);
}
?>
