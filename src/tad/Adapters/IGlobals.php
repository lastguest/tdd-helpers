<?php

/**
 * Global Variables Adatper interface
 *
 * The interface is used in the class to allow simple mocking of the class
 * using its interface in tests. PHPUnit mocking, for example:
 *
 *     $mockG = $this->getMock('tad_Adapters_IGlobals');
 */
interface tad_Adapters_IGlobals
{
    /**
     * Gets or sets the $_GLOBALS array or a variable stored in it.
     *
     *     // will return the $_GLOBALS array
     *     $globals = globals()
     *     // will set the $_GLOBALS array
     *     globals(array('some' => 'value'));
     *     // will get the `some` variable from the $_GLOBALS array
     *     $val = globals('some);
     *     // will set the `some` variable in the $_GLOBALS array
     *     globals('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_GLOBALS array to or the key to a value stored in the $_GLOBALS array.
     * @param mixed $value The value to associate to a key in the $_GLOBALS array.
     * @return mixed Either the array stored in the $_GLOBALS var or a value associated with a key.
     */
    public function globals($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_SERVER array or a variable stored in it.
     *
     *     // will return the $_SERVER array
     *     $server = server()
     *     // will set the $_SERVER array
     *     server(array('some' => 'value'));
     *     // will get the `some` variable from the $_SERVER array
     *     $val = server('some);
     *     // will set the `some` variable in the $_SERVER array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_SERVER array to or the key to a value stored in the $_SERVER array.
     * @param mixed $value The value to associate to a key in the $_SERVER array.
     * @return mixed Either the array stored in the $_SERVER var or a value associated with a key.
     */
    public function server($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_GET array or a variable stored in it.
     *
     *     // will return the $_GET array
     *     $get = get()
     *     // will set the $_GET array
     *     get(array('some' => 'value'));
     *     // will get the `some` variable from the $_GET array
     *     $val = get('some);
     *     // will set the `some` variable in the $_GET array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_GET array to or the key to a value stored in the $_GET array.
     * @param mixed $value The value to associate to a key in the $_GET array.
     * @return mixed Either the array stored in the $_GET var or a value associated with a key.
     */
    public function get($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_POST array or a variable stored in it.
     *
     *     // will return the $_POST array
     *     $post = post()
     *     // will set the $_POST array
     *     post(array('some' => 'value'));
     *     // will post the `some` variable from the $_POST array
     *     $val = post('some);
     *     // will set the `some` variable in the $_POST array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_POST array to or the key to a value stored in the $_POST array.
     * @param mixed $value The value to associate to a key in the $_POST array.
     * @return mixed Either the array stored in the $_POST var or a value associated with a key.
     */
    public function post($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_FILES array or a variable stored in it.
     *
     *     // will return the $_FILES array
     *     $files = files()
     *     // will set the $_FILES array
     *     files(array('some' => 'value'));
     *     // will files the `some` variable from the $_FILES array
     *     $val = files('some);
     *     // will set the `some` variable in the $_FILES array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_FILES array to or the key to a value stored in the $_FILES array.
     * @param mixed $value The value to associate to a key in the $_FILES array.
     * @return mixed Either the array stored in the $_FILES var or a value associated with a key.
     */
    public function files($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_COOKIE array or a variable stored in it.
     *
     *     // will return the $_COOKIE array
     *     $cookie = cookie()
     *     // will set the $_COOKIE array
     *     cookie(array('some' => 'value'));
     *     // will cookie the `some` variable from the $_COOKIE array
     *     $val = cookie('some);
     *     // will set the `some` variable in the $_COOKIE array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_COOKIE array to or the key to a value stored in the $_COOKIE array.
     * @param mixed $value The value to associate to a key in the $_COOKIE array.
     * @return mixed Either the array stored in the $_COOKIE var or a value associated with a key.
     */
    public function cookie($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_REQUEST array or a variable stored in it.
     *
     *     // will return the $_REQUEST array
     *     $request = request()
     *     // will set the $_REQUEST array
     *     request(array('some' => 'value'));
     *     // will request the `some` variable from the $_REQUEST array
     *     $val = request('some);
     *     // will set the `some` variable in the $_REQUEST array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_REQUEST array to or the key to a value stored in the $_REQUEST array.
     * @param mixed $value The value to associate to a key in the $_REQUEST array.
     * @return mixed Either the array stored in the $_REQUEST var or a value associated with a key.
     */
    public function request($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_ENV array or a variable stored in it.
     *
     *     // will return the $_ENV array
     *     $env = env()
     *     // will set the $_ENV array
     *     env(array('some' => 'value'));
     *     // will env the `some` variable from the $_ENV array
     *     $val = env('some);
     *     // will set the `some` variable in the $_ENV array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_ENV array to or the key to a value stored in the $_ENV array.
     * @param mixed $value The value to associate to a key in the $_ENV array.
     * @return mixed Either the array stored in the $_ENV var or a value associated with a key.
     */
    public function env($arrayOrKey = null, $value = null);

    /**
     * Gets or sets the $_SESSION array or a variable stored in it.
     *
     *     // will return the $_SESSION array
     *     $session = session()
     *     // will set the $_SESSION array
     *     session(array('some' => 'value'));
     *     // will session the `some` variable from the $_SESSION array
     *     $val = session('some);
     *     // will set the `some` variable in the $_SESSION array
     *     ('some', $value);
     *
     * @param array/string $arrayOrKey Either an array to set the $_SESSION array to or the key to a value stored in the $_SESSION array.
     * @param mixed $value The value to associate to a key in the $_SESSION array.
     * @return mixed Either the array stored in the $_SESSION var or a value associated with a key.
     */
    public function session($arrayOrKey = null, $value = null);
}
