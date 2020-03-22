<?php
namespace Core\DependencyInjection;

class Container
{
    protected $definitions;
    protected $dependencyTree;
    protected $objectCache;
    protected $aliases;

    public function __construct()
    {
        $this->dependencyTree = new Storage();
        $this->objectCache = new Storage();
        $this->definitions = new Storage();
        $this->aliases = new Storage();
    }

    public function share($identifier)
    {
        $identifier = $this->resolveAlias($identifier);
        $instance = $this->get($identifier);
        $this->objectCache->set($identifier, $instance);
    }

    public function alias($className, $alias)
    {
        $this->aliases->set($className, $alias);
    }

    public function define($identifier, array $parameters = array())
    {
        $identifier = $this->resolveAlias($identifier);
        $this->definitions->set($identifier, $parameters);
        $this->dependencyTree->set($identifier, $parameters);
    }

    public function get($identifier)
    {
        $identifier = $this->resolveAlias($identifier);

        if ($this->objectCache->has($identifier)) {
            return $this->objectCache->get($identifier);
        }

        return $this->create($identifier);
    }

    protected function create($identifier)
    {
        $dependencies = $this->resolveDependencies($identifier);
        $definitions = $this->definitions->get($identifier);
        $parameters = array();

        foreach ($dependencies as $name => $type) {
            if (isset($definitions[$name])) {
                $parameters[$name] = $definitions[$name];
            } else {
                $parameters[$name] = $this->get($type);
            }
        }

        $reflection = new \ReflectionClass($identifier);
        return $reflection->newInstanceArgs($parameters);
    }

    protected function resolveAlias($identifier)
    {
        return $this->aliases->get($identifier) ?? $identifier;
    }

    protected function resolveDependencies($className)
    {
        if ($this->dependencyTree->has($className)) {
            return $this->dependencyTree->get($className);
        }

        $dependencies = array();
        $reflection = new \ReflectionClass($className);

        $constructor = $reflection->getConstructor();
        if (!($constructor instanceof \ReflectionMethod)) {
            $this->dependencyTree->set($className, $dependencies);
            return $dependencies;
        }

        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType()->getName();

            $dependencies[$name] = $type;
        }

        $this->dependencyTree->set($className, $dependencies);
        return $dependencies;
    }
}