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
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}