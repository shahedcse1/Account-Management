<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Captcha extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index()
    {
        $strings = '123456789';
        $i = 0;
        $characters = 6;
        $code = '';
        while ($i < $characters)
        {
            $code .= substr($strings, mt_rand(0, strlen($strings)-1), 1);
            $i++;
        }

        $this->session->set_userdata('captcha', $code);

        /**
         * generate image
         */
        $im = imagecreatetruecolor(124, 40);
        $foreground = imagecolorallocate($im, 0, 0, 0);
        $shadow = imagecolorallocate($im, 173, 172, 168);
        $background = imagecolorallocate($im, 255, 255, 255);

        imagefilledrectangle($im, 0, 0, 200, 200, $background);

        /**
         * use your own font!
         */
        $font = 'assets/fonts/monofont_2.ttf';

        /**
         * draw text:
         */
        imagettftext($im, 35, 0, 9, 28, $shadow, $font, $code);
        imagettftext($im, 35, 0, 2, 32, $foreground, $font, $code);

        /**
         * prevent client side  caching
         */
        header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        /**
         * send image to browser
         */
        header ("Content-type: image/png");
        imagepng($im);
        imagedestroy($im);
    }

}
