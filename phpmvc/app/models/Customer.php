<?php

class Customer extends Model
{
    public function __construct()
    {
        $this->table_name = 'customer';
        $this->id_column = 'customer_id';
    }
}