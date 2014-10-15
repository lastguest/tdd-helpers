<?php

use tad\Utility\ClassReader;

class ClassReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var tad\Utility\ClassReader
     */
    protected $sut;


    protected function setUp()
    {
        $this->sut = new ClassReader();
    }

    protected function tearDown()
    {
    }

    /**
     * @test
     * it should allow passing it a file path and get the class code back
     */
    public function it_should_allow_passing_it_a_file_path_and_get_the_class_code_back()
    {
        $file = __DIR__ . '/../_dump/ClassicClass.php';
        $this->sut->setClasses($file);
        $exp = 'class ClassicClass { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }

    /**
     * @test
     * it should allow passing it multiple files
     */
    public function it_should_allow_passing_it_multiple_files()
    {
        $file2 = __DIR__ . '/../_dump/ClassicClass2.php';
        $file1 = __DIR__ . '/../_dump/ClassicClass3.php';
        $this->sut->setClasses([$file1, $file2]);
        $exp = 'class ClassicClass3 { //class code here }class ClassicClass2 { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }

    /**
     * @test
     * it should allow passing it a file with multiple classes in it
     */
    public function it_should_allow_passing_it_a_file_with_multiple_classes_in_it()
    {
        $file = __DIR__ . '/../_dump/MultiClass1.php';
        $this->sut->setClasses($file);
        $exp = 'class MultiClass1 { //class code here } class MultiClass2 { //class code here } class MultiClass3 { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }

    /**
     * @test
     * it should allow passing it multiple files with multiple classes in them
     */
    public function it_should_allow_passing_it_multiple_files_with_multiple_classes_in_them()
    {
        $file1 = __DIR__ . '/../_dump/MultiClass2.php';
        $file2 = __DIR__ . '/../_dump/MultiClass3.php';
        $this->sut->setClasses([$file1, $file2]);
        $exp = 'class MultiClass4 { //class code here } class MultiClass5 { //class code here } class MultiClass6 { //class code here }class MultiClass7 { //class code here } class MultiClass8 { //class code here } class MultiClass9 { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }

    /**
     * @test
     * it should allow passing it a defined class name
     */
    public function it_should_allow_passing_it_a_defined_class_name()
    {
        include __DIR__ . '/../_dump/ClassicClass4.php';
        $this->sut->setClasses('ClassicClass4');
        $exp = 'class ClassicClass4 { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }

    /**
     * @test
     * it should allow passing it a defined class name and a file
     */
    public function it_should_allow_passing_it_a_defined_class_name_and_a_file()
    {
        include __DIR__ . '/../_dump/ClassicClass5.php';
        $file = __DIR__ . '/../_dump/MultiClass4.php';
        $this->sut->setClasses(['ClassicClass4', $file]);
        $exp = 'class ClassicClass4 { //class code here }class MultiClass10 { //class code here } class MultiClass11 { //class code here } class MultiClass12 { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }

    /**
     * @test
     * it should allow specifying an autoload file
     */
    public function it_should_allow_specifying_an_autoload_file()
    {
        $file = __DIR__ . '/../_dump/ClassWithAutoloadParent.php';
        $this->sut->setAutoloadFile(__DIR__ . '/../_dump/pseudo_autoloader.php');
        $this->sut->setClasses($file);
        $exp = 'class ClassWithAutoloadParent extends AutoloadingParentClass{ //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }


    /**
     * @test
     * it should allow setting a file root
     */
    public function it_should_allow_setting_a_file_root()
    {
        $fileRoot = __DIR__ . '/../_dump';
        $this->sut->setFileRoot($fileRoot);
        // not loaded, not declared
        $this->sut->setClasses('ClassicClass6');
        $exp = 'class ClassicClass6 { //class code here }';

        $code = $this->sut->getClassesCode();

        $this->assertEquals($exp, $code);
    }
}