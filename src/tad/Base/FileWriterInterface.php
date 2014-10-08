<?php
/**
 * Created by PhpStorm.
 * User: Luca
 * Date: 08/10/14
 * Time: 12:15
 */

namespace tad\Base;

interface FileWriterInterface
{
    public function write();

    public function setOutputFilePath($outputFilePath);

    public function getOutputFilePath();

    public function setContents($contents);

    public function getContents();
} 