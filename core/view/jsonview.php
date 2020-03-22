<?php
namespace Core\View;

class JsonView implements IView
{
    protected $data;

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function render()
    {
        return json_encode($this->data);
    }
}