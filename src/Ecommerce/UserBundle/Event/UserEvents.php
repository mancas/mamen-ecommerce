<?php
namespace Ecommerce\UserBundle\Event;

class UserEvents
{
    const NEW_USER = 'user.new_user_created';
    const RESEND_ACTIVATION_EMAIL = 'user.resend_activation_email';
}