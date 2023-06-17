<?php

namespace App\ServiceHttp\UTalk\Entities;

class Sector
{
    public string $_t;

    public string $id;

    public string $name;

    public bool $default;

    public int $order;

    public function __construct(array $data)
    {
        $this->_t = data_get($data, '_t');
        $this->id = data_get($data, 'id');
        $this->name = data_get($data, 'name');
        $this->default = data_get($data, 'default');
        $this->order = data_get($data, 'order');
    }
}
