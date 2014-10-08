<?php

namespace tad\Generators\Adapter\Utility;

use tad\Base\FileWriterBase;

class FileWriter extends FileWriterBase
{

    public function __construct($outputFilePath = null, $contents = '')
    {
        if (!is_null($outputFilePath)) {
            $this->setOutputFilePath($outputFilePath);
        }
        $this->setContents($contents);
    }

}