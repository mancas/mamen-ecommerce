<?php
namespace Ecommerce\CartBundle\Event;

class CartEvents
{
    const NEW_CART = 'cart.new_cart_created';
    const ADD_ITEM_TO_CART = 'cart.add_item_to_cart';
    const REMOVE_ITEM_FROM_CART = 'cart.remove_item_from_cart';
    const REFRESH_CART = 'cart.refresh_cart';
    const CLEAR_CART = 'cart.clear_cart';
}