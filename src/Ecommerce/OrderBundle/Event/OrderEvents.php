<?php

namespace Ecommerce\OrderBundle\Event;

class OrderEvents
{
    const NEW_ORDER = 'order.new_order';
    const STATUS_CHANGED = 'order.status_changed';
}