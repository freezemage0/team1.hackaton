<?php
namespace Core\View;

class WebView implements IView
{
    protected const DEFAULT_TEMPLATES_FOLDER = '/assets/';

    protected $templatePath;
    protected $data;

    public function __construct()
    {
        $this->templatePath = null;
        $this->data = array();
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function addData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function get($key)
    {
        return htmlspecialchars($this->getReal($key));
    }

    public function getReal($key)
    {
        return $this->data[$key];
    }

    public function render()
    {
        if ($this->templatePath === null) {
            throw new \BadMethodCallException('Failed to render view: undefined template path.');
        }

        $templateFile = $_SERVER['DOCUMENT_ROOT'] . static::DEFAULT_TEMPLATES_FOLDER . '/' . $this->templatePath;
        if (!is_file($templateFile)) {
            throw new \InvalidArgumentException('Failed to render view: template file not found.');
        }

        return include ($templateFile);
    }
}