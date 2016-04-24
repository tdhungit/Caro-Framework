<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: CaroHelper.php
 */

namespace Modules\Backend\Models;


class CaroHelper
{
    /**
     * @param string $originalFile source file
     * @param string $targetFile destination file
     * @param int $newWidth new width
     * @param int $newHeight new height
     * @throws Exception
     */
    public static function resizeImage($originalFile, $targetFile, $newWidth = 0, $newHeight = 0)
    {
        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);

        if ($newHeight <= 0 && $newWidth > 0) {
            $newHeight = ($height / $width) * $newWidth;
        }

        if ($newWidth <= 0 && $newHeight > 0) {
            $newWidth = ($width / $height) * $newHeight;
        }

        if ($newWidth <= 0 && $newHeight <= 0) {
            $newWidth = $width;
            $newHeight = $height;
        }

        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);

        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $image_save_func($tmp, "$targetFile.$new_image_ext");
    }

    /**
     * @param string $originalFile source file
     * @param string $targetFile destination file
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     * @param int $cropWidth
     * @param int $cropHeight
     * @param bool $addExt
     * @throws Exception
     */
    public static function cropImage($originalFile, $targetFile, $x, $y, $width, $height, $cropWidth, $cropHeight, $addExt = true)
    {
        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        $src_img = $image_create_func($originalFile);

        $dst_img = imagecreatetruecolor($width, $height);
        imagealphablending($dst_img, false);
        imagesavealpha($dst_img, true);

        $transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
        imagefilledrectangle($dst_img, 0, 0, $width, $height, $transparent);
        imagecopyresampled($dst_img, $src_img, 0, 0, intval($x), intval($y), intval($width), intval($height), intval($cropWidth), intval($cropHeight));
        
        if ($addExt) {
            $image_save_func($dst_img, "$targetFile.$new_image_ext");   
        } else {
            $image_save_func($dst_img, "$targetFile");
        }
    }
}