<?php 

session_start();
$captcha_num = rand(1000, 0);
$_SESSION['code'] = $captcha_num;

// Define sizes of captcha image and also font size of captcha
$font_size = 14;
$img_width = 70;
$img_height = 40;

header('Content-type: image/jpeg'); //define content type of cpatcha.php file to image/jpeg

$image = imagecreate($img_width, $img_height); // create background image with dimensions
imagecolorallocate($image, 230, 230, 230); // set background color

$text_color = imagecolorallocate($image, 0, 0, 0); // set captcha text color

$font_path = 'arial.ttf'; // Set Path to Font File

// Create captcha image from generated captcha string. And then output this image in browser
imagettftext($image, $font_size, 0, 15, 30, $text_color, $font_path, $captcha_num);
imagejpeg($image);

?>
