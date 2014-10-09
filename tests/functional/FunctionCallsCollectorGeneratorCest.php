<?php
use tad\Generators\Adapter\FunctionCallsCollectorGenerator;
use \TestGuy;

class FunctionCallsCollectorGeneratorCest
{
    /**
     * @var string
     */
    protected $dumpFile;

    /**
     * @var FunctionCallsCollectorGenerator
     */
    protected $sut;

    public function _before(TestGuy $I)
    {
        $this->sut = new FunctionCallsCollectorGenerator();
        $this->dumpFile = implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)), '_dump', 'collectorAdapter.php']);
        $this->sut->setOutputFile($this->dumpFile);
        if (file_exists($this->dumpFile)) {
            $I->deleteFile($this->dumpFile);
        }
    }

    public function _after(TestGuy $I)
    {
    }

    /**
     * @test
     * it should write the generated class to file
     */
    public function it_should_write_the_generated_class_to_file(TestGuy $I)
    {
        $this->sut->setFileComment('blah blah');
        $this->sut->setNamespace('my\name\space');
        $this->sut->setClassComment('blah blah');
        $this->sut->setClassName('MyCollector');
        $this->sut->setInterfaceName('myInterface');
        $markup = <<< EOC
<?php

/**
 * blah blah
 */

namespace my\\name\\space;

/**
 * blah blah
 */
class MyCollector implements myInterface
EOC;

        $this->sut->generate();
        $I->openFile($this->dumpFile);
        $I->canSeeInThisFile($markup);
    }

}