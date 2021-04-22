<?php


namespace App\Factory;



use App\Entity\Oeuvre;
use App\Entity\Panier;

class PanierFactory
{
    /**
     * Creates an order.
     *
     * @return Panier
     */
    public function create(): Panier
    {
        $panier = new Panier();
        $panier->setEtat(0);
        return $panier;
    }

  /*
    public function createItem(Oeuvre $oeuvre): Panier
    {
        $panier = new OrderItem();
        $item->setProduct($product);
        $item->setQuantity(1);

        return $item;
    }*/
}