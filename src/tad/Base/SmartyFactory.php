<?php

class tad_Base_SmartyFactory implements PHP52Safe
{
    public static function on($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception('Root file path does not exists');
        }

        $smarty = new Smarty();

        $dir = dirname($filePath);
        $templateDir = $dir . '/templates';
        $cacheDir = $templateDir . '/cache';
        $compileDir = $templateDir . '/compiled';
        $configDir = $templateDir . '/config/';

        $smarty->setTemplateDir($templateDir);
        $smarty->setCacheDir($cacheDir);
        $smarty->setCompileDir($compileDir);
        $smarty->setConfigDir($configDir);

        return $smarty;
    }
} 