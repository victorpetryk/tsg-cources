<?php

class Cart extends Model
{
    public function __construct()
    {
        $this->table_name = 'cart';
        $this->id_column  = "cart_id";
    }

    public function deleteCart($id)
    {

        $sql = "delete from $this->table_name where $this->id_column = ?";

        $db = new DB();
        $db->query($sql, [$id]);

        var_dump($db);

        if ($db) {
            return true;
        }

        return false;
    }
}