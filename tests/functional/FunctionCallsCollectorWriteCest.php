<?php
use tad\Generators\Adapter\Utility\FunctionCallsCollector;
use \TestGuy;

class FunctionCallsCollectorWriteCest
{
    protected $dumpFile;
    protected $sut;

    public function _before(TestGuy $I)
    {
        $this->dumpFile = implode(DIRECTORY_SEPARATOR, [dirname(dirname(__FILE__)), '_dump', 'called_functions.json']);
        if (file_exists($this->dumpFile)) {
            @unlink($this->dumpFile);
        }
        $this->sut = new FunctionCallsCollector();
        $this->sut->_setJsonFilePath($this->dumpFile);
    }

    public function _after(TestGuy $I)
    {
    }

    /**
     * @test
     * it should write to file
     */
    public function it_should_write_to_file(TestGuy $I)
    {
        $this->sut->method_one_2134(new stdClass(), array('one'));
        $this->sut->method_two_2134('some', 23);
        $arr = [
            'method_one_2134' => [
                'name' => 'method_one_2134',
                'parameters' => [
                    'object' => [
                        'type' => 'stdClass',
                        'isPassedByReference' => false,
                        'name' => 'object',
                        'isOptional' => false,
                        'defaultValue' => false
                    ],
                    'array' => [
                        'type' => 'array',
                        'isPassedByReference' => false,
                        'name' => 'array',
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ],
            'method_two_2134' => [
                'name' => 'method_two_2134',
                'parameters' => [
                    'string' => [
                        'type' => false,
                        'isPassedByReference' => false,
                        'name' => 'string',
                        'isOptional' => false,
                        'defaultValue' => false
                    ],
                    'integer' => [
                        'type' => false,
                        'isPassedByReference' => false,
                        'name' => 'integer',
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ]
        ];
        $json = json_encode($arr);

        $this->sut = null;

        $I->openFile($this->dumpFile);
        $I->canSeeFileContentsEqual($json);
    }

    /**
     * @test
     * it should merge files
     */
    public function it_should_merge_files(TestGuy $I)
    {
        $arr = [
            'method_one_2134' => [
                'name' => 'method_one_2134',
                'parameters' => [
                    'object' => [
                        'type' => 'stdClass',
                        'isPassedByReference' => false,
                        'name' => 'object',
                        'isOptional' => false,
                        'defaultValue' => false
                    ],
                    'array' => [
                        'type' => 'array',
                        'isPassedByReference' => false,
                        'name' => 'array',
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ],
            'method_two_2134' => [
                'name' => 'method_two_2134',
                'parameters' => [
                    'string' => [
                        'type' => false,
                        'isPassedByReference' => false,
                        'name' => 'string',
                        'isOptional' => false,
                        'defaultValue' => false
                    ],
                    'integer' => [
                        'type' => false,
                        'isPassedByReference' => false,
                        'name' => 'integer',
                        'isOptional' => false,
                        'defaultValue' => false
                    ]
                ]
            ]
        ];
        $json = json_encode($arr);

        $this->sut->method_one_2134(new stdClass(), array('one'));
        $this->sut = null;
        $sut = new FunctionCallsCollector();
        $sut->_setJsonFilePath($this->dumpFile);
        $sut->_shouldAppend(true);
        $sut->method_two_2134('some', 23);
        $sut = null;

        $I->openFile($this->dumpFile);
        $I->canSeeFileContentsEqual($json);
    }
}

function method_one_2134(stdClass $object, array $array)
{

}

function method_two_2134($string, $integer)
{

}
