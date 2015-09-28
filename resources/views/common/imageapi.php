<?php
    echo $Manager->fileinclude(__FILE__);
    function getextension($path, $value=PATHINFO_EXTENSION){
        return strtolower(pathinfo($path, $value));
    }

    function loadimage($filename){
        //get image extension.
        $ext=getExtension($filename);
        //creates the new image using the appropriate function from gd library
        if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext)) {return imagecreatefromjpeg($filename);}
        if(!strcmp("png",$ext)) {return imagecreatefrompng($filename);}
        if(!strcmp("gif",$ext)) {return imagecreatefromgif($filename);}
        if(!strcmp("bmp",$ext)) {return imagecreatefrombmp($filename);}
    }

    function imagecreatefrombmp( $filename ) {
        $file = fopen( $filename, "rb" );
        $read = fread( $file, 10 );
        while( !feof( $file ) && $read != "" ){
            $read .= fread( $file, 1024 );
        }
        $temp = unpack( "H*", $read );
        $hex = $temp[1];
        $header = substr( $hex, 0, 104 );
        $body = str_split( substr( $hex, 108 ), 6 );
        if( substr( $header, 0, 4 ) == "424d" ){
            $header = substr( $header, 4 );
            $header = substr( $header, 32 );
            $width = hexdec( substr( $header, 0, 2 ) );
            $header = substr( $header, 8 );
            $height = hexdec( substr( $header, 0, 2 ) );
            unset( $header );
        }
        $x = 0;
        $y = 1;
        $image = imagecreatetruecolor( $width, $height );
        foreach( $body as $rgb ){
            $r = hexdec( substr( $rgb, 4, 2 ) );
            $g = hexdec( substr( $rgb, 2, 2 ) );
            $b = hexdec( substr( $rgb, 0, 2 ) );
            $color = imagecolorallocate( $image, $r, $g, $b );
            imagesetpixel( $image, $x, $height-$y, $color );
            $x++;
            if( $x >= $width )	{
                $x = 0;
                $y++;
            }
        }
        return $image;
    }

    // this is the function that will create the thumbnail image from the uploaded image
    // the resize will be done considering the width and height defined, but without deforming the image
    function make_thumb($img_name,$filename,$new_width,$new_height, $CropToFit = false) {
        $src_img = loadimage($img_name);
        if ($src_img) {
            //gets the dimmensions of the image
            $old_x = imageSX($src_img);
            $old_y = imageSY($src_img);

            $ratio1 = $old_x / $new_width;
            $ratio2 = $old_y / $new_height;
            if ($ratio1 > $ratio2) {
                $thumb_w = $new_width;
                $thumb_h = $old_y / $ratio1;
            } else {
                $thumb_h = $new_height;
                $thumb_w = $old_x / $ratio2;
            }
            if($CropToFit){
                if($thumb_w<$new_width){
                    $ratio1 = $new_width / $thumb_w;
                    $thumb_w = $new_width;
                    $thumb_h = $thumb_h * $ratio1;
                } else if($thumb_h<$new_height) {
                    $ratio1 = $new_height / $thumb_h;
                    $thumb_w = $thumb_w * $ratio1;
                    $thumb_h= $new_height;
                }
                $dst_img = ImageCreateTrueColor($new_width, $new_height);
                imagecopyresampled($dst_img, $src_img, $new_width / 2 - $thumb_w / 2, $new_height / 2 - $thumb_h / 2, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
            } else {
                $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
            }

            imagedestroy($src_img);
            if($filename) {
                $ext = getExtension($filename);
                switch ($ext) {
                    case "png":
                        imagepng($dst_img, $filename);
                        break;
                    default:
                        imagejpeg($dst_img, $filename);
                }
                imagedestroy($dst_img);
            } else {
                return $dst_img;
            }
            return $filename;
        }
    }
?>