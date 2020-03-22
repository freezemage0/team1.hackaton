<?php
namespace Core\Utility;

class Request
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    protected $post;
    protected $query;
    protected $cookie;
    protected $server;

    public function __construct()
    {
        $this->post = $_POST;
        $this->query = $_GET;
        $this->cookie = $_COOKIE;
        $this->server = $_SERVER;
    }

    /**
     * Возвращает параметр из массива $_GET.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getQuery($key)
    {
        return $this->query[$key] ?? null;
    }

    /**
     * Возвращает параметр из массива $_POST.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getPost($key)
    {
        return $this->post[$key] ?? null;
    }

    /**
     * Возвращает параметр из массива $_COOKIE;
     *
     * @param string $key
     * @return mixed|null
     */
    public function getCookie($key)
    {
        return $this->cookie[$key] ?? null;
    }

    /**
     * Возвращает параметр из массива $_POST, если он задан, если нет, то возвращает параметр из массива $_GET.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        $value = $this->getPost($key);

        if ($value === null) {
            $value = $this->getQuery($key);
        }

        return $value;
    }

    /**
     * Проверяет, является ли метод запроса POST.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->getRequestMethod() === static::METHOD_POST;
    }

    /**
     * Возвращает метод запроса.
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * Возвращает относительный путь для текущей страницы.
     *
     * @return string
     */
    public function getRequestedPage()
    {
        return $this->server['REQUEST_URI'];
    }

    public function getDocumentRoot()
    {
        return $this->server['DOCUMENT_ROOT'];
    }
}