<?php
namespace tad\adapters;

/**
 * An adapter class that allows accessing the superglboals in an OOP way.
 */
class Globals implements \tad\interfaces\GlobalsAdapter
{
    protected static $slugs = array('globals', 'server', 'get', 'post', 'files', 'cookie', 'request', 'env', 'session');
    /**
     * The supergloabals array.
     *
     * Keys of the array are slugs obtained as `$_GLOBALS` to `globals`, `$_SERVER` to `server`
     * and so on.
     *
     * @var array
     */
    protected $superglobals;
    /**
     * Constructs an instance of the superglobals adapter
     * @param type $superglobals An array of superglobals to initialize the instance with. If not supplied then available superglobals will be used.
     * @return void
     */
    public function __construct($superglobals = null)
    {
        if (is_null($superglobals)) {
        // inits the superglobals from the global space
            $superglobals = array(
                'globals' => $GLOBALS,
                'server' => $_SERVER,
                'get' => $_GET,
                'post' => $_POST,
                'files' => $_FILES,
                'cookie' => $_COOKIE,
                'request' => $_REQUEST,
                'env' => $_ENV
                );
            if (isset($_SESSION)) {
                $this->superglobals['session'] = $_SESSION;
            }
        }
        $this->superglobals = $superglobals;
    }
    /**
     * Allows superglobals to be accessed via an object method like
     *
     * Usage example to access $GLOBALS['foo'] is
     * 
     *     $g = new \tad\Globals();
     *     $foo = $g->globals('foo');
     * 
     * To get the superglobal array call the function with no arguments, i.e.
     * to get the $_SERVER array
     * 
     *     $g = new \tad\Globals();
     *     $g->server();
     *
     * @param string  $name The superglobal array slug (i.e. $_GET  becomes get)
     * @param array   $args The args the method was called with
     * @return mixed The array element value or null
     */
    public function __call($name, $args)
    {
        if (!is_array($args) or empty($args[0])) {
            return $this->superglobals[$name];
        }
        $key = $args[0];
        if (!isset($this->superglobals[$name]) or !isset($this->superglobals[$name][$key])) {
            return null;
        }
        return $this->superglobals[$name][$key];
    }
    /**
     * Returns the superglobals slugs
     *
     * @return array An array containing the superglobals slugs (strings). Translation is `$_GET` to `get`.
    */
    public function getSlugs()
    {
        return self::$slugs;
    }
    /**
     * Returns the superglobals array as set in the constructor
     *
     * @return array The superglobals array set or initialized in the constructor.
     */
    public function getSuperglobals()
    {
        return $this->superglobals;
    }
}
