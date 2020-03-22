<?php
namespace Core\View;

class RedirectView implements IView
{
    protected $location;

    public function render()
    {
        header('Location: ' . $this->location);
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }
}