<?php

namespace tad\Generators\Adapter\Utility;


class FileWriter
{

    protected $outputFilePath;
    protected $contents;

    public function setOutputFilePath($outputFilePath)
    {
        if (!is_string($outputFilePath)) {
            throw new \Exception('File path must be a string');
        }
        $this->outputFilePath = $outputFilePath;
    }

    public function __construct($outputFilePath = null, $contents = '')
    {
        if (!is_null($outputFilePath)) {
            $this->setOutputFilePath($outputFilePath);
        }
        $this->setContents($contents);
    }

    private function setContents($contents)
    {
        if (!is_string($contents)) {
            throw new \Exception('Content must be a string');
        }
        $this->contents = $contents;
    }

    public function write($append = false)
    {
        if (!$this->outputFilePath) {
            throw new \Exception('Output file path not set');
        }
        if (!is_writable($dir = dirname($this->outputFilePath))) {
            throw new \Exception("Folder $dir is not writable or does not exist");
        }
        if (!$this->contents) {
            throw new \Exception('Contents are not set');
        }
        file_put_contents(
            $this->outputFilePath,
            $this->contents,
            $append ? FILE_APPEND : null
        );
    }
}