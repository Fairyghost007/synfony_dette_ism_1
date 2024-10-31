<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Form\Event\PreSubmitEvent;

final class FormClientListener
{
    #[AsEventListener(event: 'form.pre_submit')]
    public function onFormPreSubmit(PreSubmitEvent $event): void
    {
        // ...
    }
}
