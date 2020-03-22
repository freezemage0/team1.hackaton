<?php
namespace Core\Connection;

class Result
{
    protected $result;

    public function __construct(\mysqli_result $result)
    {
        $this->result = $result;
    }

    public function fetch()
    {
        return $this->result->fetch_array(MYSQLI_ASSOC);
    }

    public function getSelectedRows()
    {
        return $this->result->num_rows;
    }
}