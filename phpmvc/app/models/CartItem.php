<?php

class CartItem extends Model
{
    public function __construct()
    {
        $this->table_name = 'cart_item';
        $this->id_column  = "cartitem_id";
    }

    /**
     * Отримуємо товари, що знаходяться в корзині
     *
     * @param $cartID
     *
     * @return array|bool
     */
    public function getCartItems($cartID)
    {
        $sql = <<<EOT
              SELECT p.id, p.name, p.sku, p.price, sum(i.qty) AS qty
              FROM `cart_item` i
              JOIN `products` p ON p.id = i.product_id
              WHERE i.cart_id = ?
              GROUP BY p.id;
EOT;

        $db     = new DB();
        $result = $db->query($sql, [$cartID]);

        return $result;
    }

    /**
     * Видаляемо товар з корзини
     *
     * @param $values
     *
     * @return bool
     */
    public function deleteCartItem($values)
    {
        $sql = "delete from $this->table_name where cart_id = :cart_id and product_id = :product_id";

        $db = new DB();
        $db->query($sql, $values);

        if ($db) {
            return true;
        }

        return false;
    }
}