<?php

class SmartyFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should allow getting a Smarty object
     */
    public function it_should_allow_getting_a_Smarty_object()
    {
        $this->assertInstanceOf('Smarty', tad_Base_SmartyFactory::on(__FILE__));
    }

    /**
     * @test
     * it should return a set up Smarty instance rooted to current file dir
     */
    public function it_should_return_a_set_up_smarty_instance_rooted_to_current_file_dir()
    {
        $dir = dirname(__FILE__);
        $templatesDir = $dir . '/templates/';
        $templatesCacheDir = $templatesDir . 'cache/';
        $templatesCompiledDir = $templatesDir . 'compiled/';
        $configDir = $templatesDir . 'config/';

        $sut = tad_Base_SmartyFactory::on(__FILE__);

        $this->assertEquals($templatesDir, $sut->getTemplateDir()[0]);
        $this->assertEquals($templatesCacheDir, $sut->getCacheDir());
        $this->assertEquals($templatesCompiledDir, $sut->getCompileDir());
        $this->assertEquals($configDir, $sut->getConfigDir(0));
    }
}