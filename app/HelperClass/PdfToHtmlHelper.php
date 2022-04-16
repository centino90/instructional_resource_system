<?php

namespace App\HelperClass;

/**
 * Class RD_Text_Extraction
 *
 * Example usage:
 *
 * $response = RD_Text_Extraction::convert_to_text($path_to_valid_file);
 *
 * For PDF text extraction, this class requires the Smalot\PdfParser\Parser class.
 * @see https://stackoverflow.com/questions/19503653/how-to-extract-text-from-word-file-doc-docx-xlsx-pptx-php
 *
 */
class PdfToHtmlHelper
{

    protected $fullSettings = [
        'pdftohtml_path' => 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\poppler-0.68.0\bin\pdftohtml.exe',
        'pdfinfo_path' => 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\poppler-0.68.0\bin\pdfinfo.exe',

        'generate' => [
            'singlePage' => false,
            'imageJpeg' => false,
            'ignoreImages' => false,
            'zoom' => 1.5,
            'noFrames' => true,
        ],

        'outputDir' => '',
        'removeOutputDir' => true,
        'clearAfter' => true,

        'html' => [
            'inlineCss' => true,
            'inlineImages' => true,
            'onlyContent' => true
        ]
    ];

    public $converter;
    public $converted = null;

    public function __construct($path)
    {

        $this->converter = new \TonchikTm\PdfToHtml\Pdf($path, $this->fullSettings);
    }

    public function convert($breaklineElement = ' ')
    {
        $this->converted = implode($breaklineElement, $this->converter->getHtml()->getAllPages());
    }

    public function output()
    {
        return $this->converted;
    }
}
