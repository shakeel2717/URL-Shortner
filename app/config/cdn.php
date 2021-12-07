<?php
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact gempixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package CDNs
 * @author GemPixel (http://gempixel.com)
 * @copyright 2020 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

return [
    'editor' => [
        'version' => '4.16.1',
        'js' => [
            'https://cdn.ckeditor.com/[version]/standard/ckeditor.js'
        ]
    ],
    'simpleeditor' => [
        'version' => '4.16.1',
        'js' => [
            'https://cdn.ckeditor.com/[version]/basic/ckeditor.js'
        ]
    ],
    'datetimepicker' => [
        'version' => '0.6.4',
        'js' => [
            '//cdnjs.cloudflare.com/ajax/libs/datepicker/[version]/datepicker.min.js'
        ],
        'css' => [
            '//cdnjs.cloudflare.com/ajax/libs/datepicker/[version]/datepicker.min.css'
        ]
    ],
    'codeeditor' => [
        'version' => '1.4.12',
        'js' => ['//cdnjs.cloudflare.com/ajax/libs/ace/[version]/ace.js']
    ],
    'spectrum' => [
        'version' => '1.8.1',        
        'js'=> ['//cdnjs.cloudflare.com/ajax/libs/spectrum/[version]/spectrum.min.js'],
        'css'=> ['//cdnjs.cloudflare.com/ajax/libs/spectrum/[version]/spectrum.min.css']
    ],
    'autocomplete' => [
        'version' => '1.4.11',
        'js' => ['//cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/[version]/jquery.autocomplete.min.js']
    ],
    "daterangepicker" => [
        "version" => "3.1",
        "css" => ["//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"],
        "js" => [
            "//cdn.jsdelivr.net/momentjs/latest/moment.min.js",
            "//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
          ]
    ],
    "hljs" => [
        "version" => "11.2.0",
        "js" => ["//cdnjs.cloudflare.com/ajax/libs/highlight.js/[version]/highlight.min.js"],
        "css" => ["//cdnjs.cloudflare.com/ajax/libs/highlight.js/[version]/styles/night-owl.min.css"]
    ],
    'blockadblock' => [
        'version' => '3.2.1',
        'js' => ['https://cdnjs.cloudflare.com/ajax/libs/blockadblock/[version]/blockadblock.min.js']
    ]
];