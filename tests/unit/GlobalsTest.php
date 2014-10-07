<?php
/**
 * GlobalsTest
 */
class GlobalsTest extends \PHPUnit_Framework_TestCase
{
    protected $sut;

    public function setUp()
    {
        $this->sut = new tad_Adapters_Globals();
    }

    /**
     * @test
     * it should return the GLOBALS array
     */
    public function it_should_return_the_globals_array()
    {
        $GLOBALS = ['foo' => 'baz'];
        $this->assertEquals($GLOBALS, $this->sut->globals());
    }

    /**
     * @test
     * it should set the GLOBALS array
     */
    public function it_should_set_the_globals_array()
    {
        $GLOBALS = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->globals($arr);
        $this->assertEquals($arr, $this->sut->globals());
    }

    /**
     * @test
     * it should get a value stored in the GLOBALS array
     */
    public function it_should_get_a_value_stored_in_the_globals_array()
    {
        $GLOBALS = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->globals('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the GLOBALS array
     */
    public function it_should_set_a_value_stored_in_the_globals_array()
    {
        $value = 'foo';
        $GLOBALS = [];
        $this->sut->globals('key', $value);
        $this->assertEquals($value, $this->sut->globals('key'));
    }

    /**
     * @test
     * it should return the _SERVER array
     */
    public function it_should_return_the_server_array()
    {
        $_SERVER = ['foo' => 'baz'];
        $this->assertEquals($_SERVER, $this->sut->server());
    }

    /**
     * @test
     * it should set the _SERVER array
     */
    public function it_should_set_the_server_array()
    {
        $_SERVER = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->server($arr);
        $this->assertEquals($arr, $this->sut->server());
    }

    /**
     * @test
     * it should get a value stored in the _SERVER array
     */
    public function it_should_get_a_value_stored_in_the_server_array()
    {
        $_SERVER = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->server('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _SERVER array
     */
    public function it_should_set_a_value_stored_in_the_server_array()
    {
        $value = 'foo';
        $_SERVER = [];
        $this->sut->server('key', $value);
        $this->assertEquals($value, $this->sut->server('key'));
    }

    /**
     * @test
     * it should return the _GET array
     */
    public function it_should_return_the_get_array()
    {
        $_GET = ['foo' => 'baz'];
        $this->assertEquals($_GET, $this->sut->get());
    }

    /**
     * @test
     * it should set the _GET array
     */
    public function it_should_set_the_get_array()
    {
        $_GET = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->get($arr);
        $this->assertEquals($arr, $this->sut->get());
    }

    /**
     * @test
     * it should get a value stored in the _GET array
     */
    public function it_should_get_a_value_stored_in_the_get_array()
    {
        $_GET = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->get('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _GET array
     */
    public function it_should_set_a_value_stored_in_the_get_array()
    {
        $value = 'foo';
        $_GET = [];
        $this->sut->get('key', $value);
        $this->assertEquals($value, $this->sut->get('key'));
    }

    /**
     * @test
     * it should return the _POST array
     */
    public function it_should_return_the_post_array()
    {
        $_POST = ['foo' => 'baz'];
        $this->assertEquals($_POST, $this->sut->post());
    }

    /**
     * @test
     * it should set the _POST array
     */
    public function it_should_set_the_post_array()
    {
        $_POST = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->post($arr);
        $this->assertEquals($arr, $this->sut->post());
    }

    /**
     * @test
     * it should post a value stored in the _POST array
     */
    public function it_should_post_a_value_stored_in_the_post_array()
    {
        $_POST = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->post('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _POST array
     */
    public function it_should_set_a_value_stored_in_the_post_array()
    {
        $value = 'foo';
        $_POST = [];
        $this->sut->post('key', $value);
        $this->assertEquals($value, $this->sut->post('key'));
    }

    /**
     * @test
     * it should return the _FILES array
     */
    public function it_should_return_the_files_array()
    {
        $_FILES = ['foo' => 'baz'];
        $this->assertEquals($_FILES, $this->sut->files());
    }

    /**
     * @test
     * it should set the _FILES array
     */
    public function it_should_set_the_files_array()
    {
        $_FILES = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->files($arr);
        $this->assertEquals($arr, $this->sut->files());
    }

    /**
     * @test
     * it should files a value stored in the _FILES array
     */
    public function it_should_files_a_value_stored_in_the_files_array()
    {
        $_FILES = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->files('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _FILES array
     */
    public function it_should_set_a_value_stored_in_the_files_array()
    {
        $value = 'foo';
        $_FILES = [];
        $this->sut->files('key', $value);
        $this->assertEquals($value, $this->sut->files('key'));
    }

    /**
     * @test
     * it should return the _COOKIE array
     */
    public function it_should_return_the_cookie_array()
    {
        $_COOKIE = ['foo' => 'baz'];
        $this->assertEquals($_COOKIE, $this->sut->cookie());
    }

    /**
     * @test
     * it should set the _COOKIE array
     */
    public function it_should_set_the_cookie_array()
    {
        $_COOKIE = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->cookie($arr);
        $this->assertEquals($arr, $this->sut->cookie());
    }

    /**
     * @test
     * it should cookie a value stored in the _COOKIE array
     */
    public function it_should_cookie_a_value_stored_in_the_cookie_array()
    {
        $_COOKIE = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->cookie('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _COOKIE array
     */
    public function it_should_set_a_value_stored_in_the_cookie_array()
    {
        $value = 'foo';
        $_COOKIE = [];
        $this->sut->cookie('key', $value);
        $this->assertEquals($value, $this->sut->cookie('key'));
    }

    /**
     * @test
     * it should return the _SESSION array
     */
    public function it_should_return_the_session_array()
    {
        $_SESSION = ['foo' => 'baz'];
        $this->assertEquals($_SESSION, $this->sut->session());
    }

    /**
     * @test
     * it should set the _SESSION array
     */
    public function it_should_set_the_session_array()
    {
        $_SESSION = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->session($arr);
        $this->assertEquals($arr, $this->sut->session());
    }

    /**
     * @test
     * it should session a value stored in the _SESSION array
     */
    public function it_should_session_a_value_stored_in_the_session_array()
    {
        $_SESSION = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->session('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _SESSION array
     */
    public function it_should_set_a_value_stored_in_the_session_array()
    {
        $value = 'foo';
        $_SESSION = [];
        $this->sut->session('key', $value);
        $this->assertEquals($value, $this->sut->session('key'));
    }

    /**
     * @test
     * it should return the _REQUEST array
     */
    public function it_should_return_the_request_array()
    {
        $_REQUEST = ['foo' => 'baz'];
        $this->assertEquals($_REQUEST, $this->sut->request());
    }

    /**
     * @test
     * it should set the _REQUEST array
     */
    public function it_should_set_the_request_array()
    {
        $_REQUEST = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->request($arr);
        $this->assertEquals($arr, $this->sut->request());
    }

    /**
     * @test
     * it should request a value stored in the _REQUEST array
     */
    public function it_should_request_a_value_stored_in_the_request_array()
    {
        $_REQUEST = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->request('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _REQUEST array
     */
    public function it_should_set_a_value_stored_in_the_request_array()
    {
        $value = 'foo';
        $_REQUEST = [];
        $this->sut->request('key', $value);
        $this->assertEquals($value, $this->sut->request('key'));
    }

    /**
     * @test
     * it should return the _ENV array
     */
    public function it_should_return_the_env_array()
    {
        $_ENV = ['foo' => 'baz'];
        $this->assertEquals($_ENV, $this->sut->env());
    }

    /**
     * @test
     * it should set the _ENV array
     */
    public function it_should_set_the_env_array()
    {
        $_ENV = [];
        $arr = ['someValue' => 'someVar'];
        $this->sut->env($arr);
        $this->assertEquals($arr, $this->sut->env());
    }

    /**
     * @test
     * it should env a value stored in the _ENV array
     */
    public function it_should_env_a_value_stored_in_the_env_array()
    {
        $_ENV = ['someVar' => 'someValue'];
        $this->assertEquals('someValue', $this->sut->env('someVar'));
    }

    /**
     * @test
     * it should set a value stored in the _ENV array
     */
    public function it_should_set_a_value_stored_in_the_env_array()
    {
        $value = 'foo';
        $_ENV = [];
        $this->sut->env('key', $value);
        $this->assertEquals($value, $this->sut->env('key'));
    }
}
