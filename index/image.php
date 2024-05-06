<?php
class Image
{
    public function generate_filename($length)
    {
        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $text = "";
        for ($x = 0; $x < $length; $x++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }
        return $text;
    }
    public function crop_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        if (file_exists($original_file_name)) {
            
         
           $image_type = @exif_imagetype($original_file_name); // Suppress warnings with @

           if (!$image_type) {
               // Handle error: Couldn't determine image type or error reading the file.
               return false;
           }

            switch ($image_type) {
                case IMAGETYPE_JPEG:
                    $original_image = imagecreatefromjpeg($original_file_name);
                    break;
                case IMAGETYPE_PNG:
                    $original_image = imagecreatefrompng($original_file_name);
                    break;
                case IMAGETYPE_WEBP:
                    $original_image = imagecreatefromwebp($original_file_name);
                    break;
                default:
                    return false;  // Or handle error as you see fit
            }

            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            if ($original_height > $original_width) {
                //make width equal to max width;
                $ratio = $max_width / $original_width;

                $new_width = $max_width;
                $new_height = $original_height * $ratio;
            } else {
                //make width equal to max width;
                $ratio = $max_height / $original_height;

                $new_height = $max_height;
                $new_width = $original_width * $ratio;
            }
        }
        //adjust incase max width and height are different
        if ($max_width != $max_height) {
            if ($max_height > $max_width) {
                if ($max_height > $new_height) {
                    $adjustment = ($max_height / $new_height);
                } else {
                    $adjustment = ($new_height / $max_height);
                }

                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            } else {
                if ($max_width > $new_width) {
                    $adjustment = ($max_width / $new_width);
                } else {
                    $adjustment = ($new_width / $max_width);
                }

                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        imagedestroy($original_image);

        if ($max_width != $max_height) {
            if ($max_width > $max_height) {
                $diff = ($new_height - $max_height);
                if ($diff < 0) {
                    $diff = $diff * -1;
                }
                $y = round($diff / 2);
                $x = 0;
            } else {
                $diff = ($new_width - $max_height);
                if ($diff < 0) {
                    $diff = $diff * -1;
                }
                $y = round($diff / 2);
                $x = 0;
            }
        } else {
            if ($new_height > $new_width) {
                $diff = ($new_height - $new_width);
                $y = round($diff / 2);
                $x = 0;
            } else {
                $diff = ($new_width - $new_height);
                $y = round($diff / 2);
                $x = 0;
            }
        }

        $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
        imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
        imagedestroy($new_image);
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_cropped_image, $cropped_file_name, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($new_cropped_image, $cropped_file_name, 90);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($new_cropped_image, $cropped_file_name, 90);
                break;
        }
        imagedestroy($new_cropped_image);
    }

    //ปรับขนาดของภาพ (resize the image)
    public function resize_image($original_file_name, $resized_file_name, $max_width, $max_height)
    {
        if (file_exists($original_file_name)) {
            $image_type = exif_imagetype($original_file_name);

            switch ($image_type) {
                case IMAGETYPE_JPEG:
                    $original_image = imagecreatefromjpeg($original_file_name);
                    break;
                case IMAGETYPE_PNG:
                    $original_image = imagecreatefrompng($original_file_name);
                    break;
                case IMAGETYPE_WEBP:
                    $original_image = imagecreatefromwebp($original_file_name);
                    break;
                default:
                    return false;  // Or handle error as you see fit
            }

            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            if ($original_height > $original_width) {
                //make width equal to max width;
                $ratio = $max_width / $original_width;

                $new_width = $max_width;
                $new_height = $original_height * $ratio;
            } else {
                //make width equal to max width;
                $ratio = $max_height / $original_height;

                $new_height = $max_height;
                $new_width = $original_width * $ratio;
            }
        }
        //adjust incase max width and height are different
        if ($max_width != $max_height) {
            if ($max_height > $max_width) {
                if ($max_height > $new_height) {
                    $adjustment = ($max_height / $new_height);
                } else {
                    $adjustment = ($new_height / $max_height);
                }

                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            } else {
                if ($max_width > $new_width) {
                    $adjustment = ($max_width / $new_width);
                } else {
                    $adjustment = ($new_width / $max_width);
                }

                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        imagedestroy($original_image);


        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_image, $resized_file_name, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($new_image, $resized_file_name, 9);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($new_image, $resized_file_name, 90);
                break;
        }
        imagedestroy($new_image);
    }

    // create thumbnail for cover image
    // สร้างภาพขนาดย่อสำหรับการทำ background
    public function get_thumb_cover($filename)
    {
        $thumbnail = $filename . "_cover_thumb.jpg";
        if(file_exists( $thumbnail))
        {
            return  $thumbnail;
        }
        $this->crop_image($filename, $thumbnail, 1366, 488);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        } else{
            return $filename; 
        }
    }
    // create thumbnail for profile image
    // สร้างภาพขนาดย่อสำหรับการทำ รูปโปรไฟล์
    public function get_thumb_profile($filename)
    {
        $thumbnail = $filename . "_profile_thumb.jpg";
        if(file_exists( $thumbnail))
        {
            return  $thumbnail;
        }
        $this->crop_image($filename, $thumbnail, 600, 600);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        } else{
            return $filename; 
        }
    }
    // create thumbnail for post image
    // สร้างภาพขนาดย่อสำหรับการทำ รูปโปรไฟล์
    public function get_thumb_post($filename)
    {
        $thumbnail = $filename . "_post_thumb.jpg";
        if(file_exists( $thumbnail))
        {
            return  $thumbnail;
        }
        $this->crop_image($filename, $thumbnail, 600, 600);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        } else{
            return $filename; 
        }
    }
}
