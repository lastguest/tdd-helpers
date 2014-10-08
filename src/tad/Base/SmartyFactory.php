<?php

class tad_Base_SmartyFactory implements PHP52Safe
{
    protected $templateDir = '/templates';
    protected $cacheDir = '/cache';
    protected $compileDir = '/compiled';
    protected $configDir = '/config/';


    public static function on($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception('Root file path does not exists');
        }

        $instance = new self();

        return $instance->getSmartyOn($filePath);
    }

    /**
     * @param $filePath
     * @return Smarty
     */
    public function getSmartyOn($filePath)
    {
        $smarty = new Smarty();

        $dir = dirname($filePath);

        $templateDir = $dir . $this->templateDir;
        $cacheDir = $templateDir . $this->cacheDir;
        $compileDir = $templateDir . $this->compileDir;
        $configDir = $templateDir . $this->configDir;

        $smarty->setTemplateDir($templateDir);
        $smarty->setCacheDir($cacheDir);
        $smarty->setCompileDir($compileDir);
        $smarty->setConfigDir($configDir);

        return $smarty;
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @param string $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return string
     */
    public function getCompileDir()
    {
        return $this->compileDir;
    }

    /**
     * @param string $compileDir
     */
    public function setCompileDir($compileDir)
    {
        $this->compileDir = $compileDir;
    }

    /**
     * @return string
     */
    public function getConfigDir()
    {
        return $this->configDir;
    }

    /**
     * @param string $configDir
     */
    public function setConfigDir($configDir)
    {
        $this->configDir = $configDir;
    }

    /**
     * @return string
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

    /**
     * @param string $templateDir
     */
    public function setTemplateDir($templateDir)
    {
        $this->templateDir = $templateDir;
    }

}