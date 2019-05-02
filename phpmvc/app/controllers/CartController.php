<?php

class CartController extends Controller
{
    protected $registry = array();

    public function ListAction()
    {
        $this->setTitle('Корзина');

        $cartID = Helper::getCartID();

        $this->registry['cart-items'] = $this->getModel('CartItem')->getCartItems($cartID);

        $this->setView();
        $this->renderLayout();
    }

    public function AddAction()
    {
        $cartID = Helper::getCartID();

        $productID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $this->getModel('CartItem')->addItem(
            [
                'cart_id'    => $cartID,
                'product_id' => $productID,
                'qty'        => 1
            ]
        );

        $_SESSION['success'] = 'Товар успішно додано в корзину!';

        Helper::redirect('/product/list');
    }

    public function DeleteAction()
    {
        $productID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $model = $this->getModel('CartItem');

        $model->deleteCartItem(
            [
                'cart_id'    => Helper::getCartID(),
                'product_id' => $productID
            ]
        );

        $_SESSION['success'] = 'Товар успішно видалено з корзини!';

        Helper::redirect('/cart/list');
    }

    public function CheckoutAction()
    {
        if ( ! Helper::getCustomer()) {
            $customer = "Гість #" . Helper::getCartID();
        } else {
            $customer = Helper::getCustomer()['last_name'] . ' ' . Helper::getCustomer()['first_name'];
        }

        $cartID    = Helper::getCartID();
        $cartItems = $this->getModel('CartItem')->getCartItems($cartID);
        $total     = 0;

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><order/>');
        $xml->addChild('customer', $customer);
        $xmlProducts = $xml->addChild('products');

        foreach ($cartItems as $cartItem) {
            $xmlProduct = $xmlProducts->addChild('product');
            $xmlProduct->addChild('sku', $cartItem['sku']);
            $xmlProduct->addChild('name', $cartItem['name']);
            $xmlProduct->addChild('price', $cartItem['price']);
            $xmlProduct->addChild('qty', $cartItem['qty']);

            $sum   = (int)$cartItem['qty'] * $cartItem['price'];
            $total += $sum;

            $xmlProduct->addChild('sum', $sum);
        }

        $xml->addChild('total', $total);

        $dom                     = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;
        $dom->loadXML($xml->asXML());

        $filePath = ROOT . '/public/order-' . date('d-m-Y-Hi') . '.xml';

        $file = fopen($filePath, "w");

        chmod($filePath, 0775);

        fwrite($file, $dom->saveXML());
        fclose($file);

        // Видаляємо корзину з товарами після оформлення замовлення
        $this->getModel('Cart')->deleteCart($cartID);

        $_SESSION['success'] = 'Дякуюмо за замовлення!';
        Helper::redirect('/cart/list');
    }
}