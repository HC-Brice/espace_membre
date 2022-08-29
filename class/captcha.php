<?php
session_start();
$length = 5;
$letters = 'aAbBCDeEFgGhHJKLmMnNpPqQRsStTuVwWXYZz2345679';
$number = strlen($letters);
$string = '';
for ($i = 0; $i < $length; $i++) {
	$string .= $letters[mt_rand(0, $number - 1)];
}
$_SESSION["code"]=$string;
$image = imagecreatetruecolor(50, 24);
$background = imagecolorallocate($image, 250, 250, 250); 
$forground = imagecolorallocate($image, 0, 0, 0);
imagefill($image, 0, 0, $background);
imagestring($image, 5, 5, 5,  $string, $forground);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>