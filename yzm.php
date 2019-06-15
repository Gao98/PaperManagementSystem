<?php
   session_start();
   define("CHARS_lLENGTH", 4);;
   function getVerify(){    //生成验证码
     $strings=Array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v', 'w','x','y','z');
     $chrNum="";
     $count=count($strings);
     for($i=1;$i<=CHARS_lLENGTH;$i++)
        $chrNum.=$strings[rand(0,$count-1)];
     return $chrNum;
   }
   function GetImage($strNum){  //生成验证码图像
      $fontSize=15; $width=70; $height=24; $pointNum=0;
      $im=imagecreate($width+5,$height+5);
      $backgrountColor=imagecolorallocate($im,255,239,206);
      $frameColor=imagecolorallocate($im,155,155,155);
      $stringColor=imagecolorallocate($im,30,30,30);
      $font=realpath("FONT_PATH/arial.ttf");
      for($i=0;$i<CHARS_lLENGTH;$i++){
         $charY=($height+$height/2)/2+rand(-1,1);
         $charX=$i*15+8;
         $text_color=imagecolorallocate($im,mt_rand(50,200),mt_rand(50,128),mt_rand(50,200));
         $angle=rand(-30,30);
         imagettftext($im,$fontSize,$angle,$charX,$charY,$text_color,$font,$strNum[$i]);
      }
      for($i=0;$i<=5;$i++){
         $linecolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
         $lineX=mt_rand(1,$width-1);
         $lineY=mt_rand(1,$height-1);
         imageline($im,$lineX,$lineY,$lineX+mt_rand(0,4)-2,$lineY+mt_rand(0,4)-2,$linecolor);
      }
       for($i=0;$i<=32;$i++){
         $pointcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
         imagesetpixel($im,mt_rand(1,$width-1),mt_rand(1,$height-1),$pointcolor);
      }
      imagerectangle($im,0,0,$width-1,$height-1,$framecolor);
      ob_clean();
      header('Content-type:image/png');
      imagepng($im);
      imagedestroy($im);
      exit;
   }
   $chars=getVerify();
   $_SESSION['chars']=$chars;
   imagejpeg(GetImage($chars));
?>