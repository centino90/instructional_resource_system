<?php

namespace App\HelperClass;

use NcJoes\OfficeConverter\OfficeConverter;

class OfficeToPdfHelper extends OfficeConverter
{

    protected $bin;

    public function __construct($filename, $tempPath, $bin = null, $prefixExecWithExportHome = true)
    {
        $this->bin = env('SOFFICE_PATH', 'C:\Users\AJ\Documents\GitHub\instructional_resource_system\LibreOffice\program\soffice.bin');
        if ($bin) {
            $this->bin = $bin;
        }

        if ($this->open($filename)) {
            $this->setup($tempPath, $this->bin, $prefixExecWithExportHome);
        }
    }
}
