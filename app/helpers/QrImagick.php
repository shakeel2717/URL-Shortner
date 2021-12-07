<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */

namespace Helpers;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Exception\WriterException;
use BaconQrCode\Renderer\Color\Alpha;
use BaconQrCode\Renderer\Color\ColorInterface;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Eye\EyeInterface;
use BaconQrCode\Renderer\Eye\ModuleEye;
use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\ImageBackEndInterface;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Module\DotsModule;
use BaconQrCode\Renderer\Module\ModuleInterface;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererStyle\EyeFill;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\Gradient;
use BaconQrCode\Renderer\RendererStyle\GradientType;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QRImagick {
    /**
     * Instance of the writer
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $writer = null;
    /**
     * Add Logo
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $logo = null;
    /**
     * Get Extension
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $extension = null;    
    /**
     * Instance of the QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $Qr = null;    

    /**
     * Generate QR Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct($data, $size = 200, $margin = 10){
        
        $this->Qr = new \stdClass;

        $this->Qr->module = SquareModule::instance();

        $this->Qr->eye = SquareEye::instance();

        $this->Qr->fill = Fill::withForegroundColor(new Rgb(255,255,255), new Rgb(0,0,0), EyeFill::inherit(), EyeFill::inherit(), EyeFill::inherit());

        $this->Qr->data = $data;
        $this->Qr->size = $size;
        $this->Qr->margin = $margin;

        $this->Qr->logo = null;

        return $this;
        
    }   
    /**
     * Add Logo
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $path
     * @param integer $size
     * @return void
     */
    public function withLogo($path, $size = 50){
        $this->Qr->logo = [$path, $size];
        return $this;
    }
    /**
     * Create a QR Code format
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function format($format = 'png'){
        
        // if($format == 'pdf'){
            
        //     $this->writer = new PdfWriter();
        //     $this->extension = "pdf";

        // } else
        if($format == 'svg'){        

            $this->writer = new SvgImageBackEnd();
            $this->extension = "svg";

        } else {

            $this->writer = new ImagickImageBackEnd();
            $this->extension = "png";    

        }

        return $this;
    }
    /**
     * Set Background and Foreground color
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param array $bg
     * @param array $fg
     * @return void
     */
    public function color($fg, $bg, $eye = null){
        
        \preg_match('|rgb\((.*)\)|', $bg, $color);
        $bgColor = \explode(',', $color[1]);
        $this->Qr->bgColor = new Rgb(...$bgColor);

        $this->Qr->eyeColor = EyeFill::inherit();

        if($eye){

            \preg_match('|rgb\((.*)\)|', $eye, $color);
            $eyeColor = \explode(',', $color[1]);
            $this->Qr->eyeColor = new EyeFill(new Rgb(...$eyeColor), new Rgb(...$eyeColor));
        }


        \preg_match('|rgb\((.*)\)|', $fg, $color);
        $fgColor = \explode(',', $color[1]);
        $this->Qr->fgColor = new Rgb(...$fgColor);

        $this->Qr->fill = Fill::withForegroundColor($this->Qr->bgColor, $this->Qr->fgColor,$this->Qr->eyeColor, $this->Qr->eyeColor, $this->Qr->eyeColor);

        return $this;
    }
    /**
     * Gradient
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $fg
     * @param [type] $bg
     * @param [type] $eye
     * @return void
     */
    public function gradient($fg, $bg, $type, $eye = null){

        $this->Qr->eyeColor = EyeFill::inherit();

        \preg_match('|rgb\((.*)\)|', $bg, $color);
        $bgColor = \explode(',', $color[1]);
        $this->Qr->bgColor = new Rgb(...$bgColor);
        
        if($eye){

            \preg_match('|rgb\((.*)\)|', $eye, $color);
            $eyeColor = \explode(',', $color[1]);
            $this->Qr->eyeColor = new EyeFill(new Rgb(...$eyeColor), new Rgb(...$eyeColor));
        }

        $fgColor = [];

        foreach($fg as $fgcolor){
            \preg_match('|rgb\((.*)\)|', $fgcolor, $color);
            $fgColor[] = new Rgb(...\explode(',', $color[1]));
        }

        if(in_array($type, ['vertical', 'horizontal', 'diagonal', 'radial'])){
            $type = strtoupper($type);
            $fgColor[] = GradientType::$type();
        } else{
            $fgColor[] = GradientType::VERTICAL();
        }


        $this->Qr->fgColor = new Gradient($fgColor[0], $fgColor[1], $fgColor[2]);

        $this->Qr->fill = Fill::withForegroundGradient($this->Qr->bgColor, $this->Qr->fgColor, $this->Qr->eyeColor, $this->Qr->eyeColor, $this->Qr->eyeColor);

        return $this;
    }

    /**
     * Eye
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $type
     * @return void
     */
    public function eye($type = 'square'){
        
        if ($type === 'circle') {

            $this->Qr->eye = SimpleCircleEye::instance();

        }

        return $this;
    }
    /**
     * Module 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $type
     * @param float $size
     * @return void
     */
    public function module($type = 'square', $size = 0.5){

        if ($type == 'dot') {
            $this->Qr->module = new DotsModule($size*1.3);
        }

        if ($type == 'circle') {
            $this->Qr->module = new RoundnessModule($size);
        }
        return $this;
    }
    /**
     * Download QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function string(){

        $renderer = new ImageRenderer(
            new RendererStyle($this->Qr->size, $this->Qr->margin, $this->Qr->module, $this->Qr->eye, $this->Qr->fill),
            $this->writer
        );
        
        $writer = new Writer($renderer);    

        return $writer->writeString($this->Qr->data, 'UTF-8', ErrorCorrectionLevel::H());             
    }
    /**
     * Return extension
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function extension(){    
        return $this->extension;
    }
    /**
     * Get Mime Type
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function getMimeType(){

        if($this->extension == 'svg'){        
            return 'image/svg+xml';
        } else {
            return 'image/png';
        }
    }
    /**
     * Generate QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create($output = 'raw', $file = null){

        
        $renderer = new ImageRenderer(
            new RendererStyle($this->Qr->size, $this->Qr->margin, $this->Qr->module, $this->Qr->eye, $this->Qr->fill),
            $this->writer
        );
        
        $writer = new Writer($renderer);    

        $qr = $writer->writeString($this->Qr->data, 'UTF-8', ErrorCorrectionLevel::H());

        if($this->Qr->logo){

            $src = new \Imagick;
            $src->readImageBlob($qr);
            $src->setImageFormat('png'); 

            $src2 = new \Imagick($this->Qr->logo[0]);
            $src2->setImageFormat('png'); 
            $src2->resizeimage($this->Qr->logo[1], $this->Qr->logo[1], \Imagick::FILTER_LANCZOS, 1); 

            $new = new \Imagick();

            $new->newimage( $this->Qr->size, $this->Qr->size, "none");
                
            $new->compositeimage($src->getimage(), \Imagick::COMPOSITE_COPY, 0, 0);
            $new->compositeimage($src2->getimage(), \Imagick::COMPOSITE_COPY, ($this->Qr->size - $this->Qr->logo[1]) /2, ($this->Qr->size - $this->Qr->logo[1]) /2); 
            $new->setImageFormat('png'); 
            
            $qr = $new->getImageBlob();
        }

        if($output == 'file'){
            return file_put_contents($file, $qr);
        }

        if($output == 'uri'){

            return 'data:'.$this->getMimeType().';base64,'.base64_encode($qr);
        }
        
        header('Content-Type: '.$this->getMimeType());
        echo $qr;
        exit;
    }    

}