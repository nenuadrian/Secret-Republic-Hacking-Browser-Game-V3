<?php

/**
 * Simple Dependency Injection Container for Secret Republic.
 *
 * Replaces the previous system of 20+ global variables by holding all shared
 * services and request-scoped state in a single, injectable object.
 *
 * Usage in the composition root (index.php):
 *   $container = new Container();
 *   $container->set('db', $dbInstance);
 *
 * Usage in classes (via Alpha base class):
 *   $this->container->get('db')->where(...);
 *
 * Usage in modules:
 *   $db = $container->get('db');
 */
class Container
{
    /** @var array Registered service instances */
    private $services = [];

    /** @var array Factory callables keyed by service name */
    private $factories = [];

    /**
     * Register a pre-built instance.
     */
    public function set(string $name, $instance): void
    {
        $this->services[$name] = $instance;
    }

    /**
     * Register a lazy factory. The callable receives this Container and is
     * invoked at most once; the result is cached.
     */
    public function factory(string $name, callable $factory): void
    {
        $this->factories[$name] = $factory;
    }

    /**
     * Retrieve a service by name.
     */
    public function get(string $name)
    {
        if (array_key_exists($name, $this->services)) {
            return $this->services[$name];
        }

        if (isset($this->factories[$name])) {
            $this->services[$name] = ($this->factories[$name])($this);
            unset($this->factories[$name]);
            return $this->services[$name];
        }

        throw new \RuntimeException("Service not found in container: {$name}");
    }

    /**
     * Check whether a service is registered (either as instance or factory).
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->services) || isset($this->factories[$name]);
    }

    // ---------------------------------------------------------------
    // Convenience accessors for the most common services.
    // These keep call-sites readable and provide IDE auto-complete
    // without coupling every consumer to a concrete class.
    // ---------------------------------------------------------------

    /** @return Mysqlidb|SqliteDb */
    public function db()        { return $this->get('db'); }
    public function config()    { return $this->get('config'); }
    public function user()      { return $this->get('user'); }
    public function uclass()    { return $this->get('uclass'); }
    public function taskclass() { return $this->get('taskclass'); }
    public function smarty()    { return $this->get('smarty'); }

    // ---------------------------------------------------------------
    // Request-scoped mutable state (messages, template vars, etc.)
    // Stored here instead of as bare globals.
    // ---------------------------------------------------------------

    public $tVars     = [];
    public $errors    = [];
    public $success   = [];
    public $info      = [];
    public $warnings  = [];
    public $messenger = [];
    public $myModals  = [];
    public $voice     = '';
    public $logged    = false;
    public $GET       = [];
    public $url       = '';
    public $pages     = null;
}
