<?php
namespace Core\Security;

class Session
{
    protected $session;

    public function __construct()
    {
        $this->start();
        $this->session = $_SESSION;
    }

    public function start()
    {
        session_start();
    }

    public function close()
    {
        session_write_close();
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function destroy()
    {
        session_destroy();
    }
}