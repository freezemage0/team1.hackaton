<?php
namespace Core\Utility;

class Uri
{
    protected $host;
    protected $path;
    protected $query;
    protected $scheme;

    public function __construct($url)
    {
        $url = parse_url($url);
        if ($url === false) {
            throw new \InvalidArgumentException('Failed to build Uri: malformed URL');
        }

        $this->scheme = $url['scheme'] ?? null;
        $this->host = $url['host'] ?? null;
        $this->path = $url['path'] ?? null;
        $this->query = $this->parseQuery($url['query']);
    }

    public function getLocator(): string
    {
        $locator = $this->getScheme() . '://' . $this->getHost() . '/' . $this->getPath() . '?' . $this->getQuery();
        return $locator;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    public function removeQueryParameter(string $key): void
    {
        unset($this->query[$key]);
    }

    public function setQueryParameter(string $key, $value): void
    {
        $this->query[$key] = $value;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return http_build_query($this->query);
    }

    protected function parseQuery(string $rawQuery): array
    {
        $parts = explode('=' , $rawQuery);
        $query = array();

        foreach ($parts as $name => $value) {
            $query[$name] = $value;
        }

        return $query;
    }

    /**
     * @param array $query
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }
}