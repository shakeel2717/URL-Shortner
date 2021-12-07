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

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\PdfWriter;
use Endroid\QrCode\Writer\SvgWriter;

class QRGd {
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
    private $QR = null;    

    /**
     * Generate QR Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct($data, $size = 200, $margin = 10){
        
        $this->qrCode = QrCode::create($data)
                        ->setEncoding(new Encoding('UTF-8'))
                        ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
                        ->setSize($size)
                        ->setMargin($margin)
                        ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin());

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
        $this->logo = Logo::create($path)
                    ->setResizeToWidth($size);
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
        
        if($format == 'pdf'){
            $this->writer = new PdfWriter();
            $this->extension = "pdf";
        } elseif($format == 'svg'){        
            $this->writer = new SvgWriter();
            $this->extension = "svg";
        } else {
            $this->writer = new PngWriter();
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
    public function color($fg, $bg){

        \preg_match('|rgb\((.*)\)|', $fg, $color);
        $fgColor = \explode(',', $color[1]);

        \preg_match('|rgb\((.*)\)|', $bg, $color);
        $bgColor = \explode(',', $color[1]);

        $this->qrCode->setForegroundColor(new Color($fgColor[0], $fgColor[1], $fgColor[2]))
                     ->setBackgroundColor(new Color($bgColor[0], $bgColor[1], $bgColor[2]));

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
        $result = $this->writer->write($this->qrCode, $this->logo);
        echo $result->getString();
        exit;        
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
     * Generate QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create($output = 'raw', $file = null){

        $result = $this->writer->write($this->qrCode, $this->logo);

        if($output == 'file'){
            $result->saveToFile($file);
            return true;
        }
        
        if($output == 'uri'){
            return $result->getDataUri();            
        }

        header('Content-Type: '.$result->getMimeType());
        echo $result->getString();
        exit;
    }    

}