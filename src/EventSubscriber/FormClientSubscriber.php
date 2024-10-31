<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PreSubmitEvent;
use App\Form\UserType;


class FormClientSubscriber implements EventSubscriberInterface
{
    public function onFormPreSubmit(PreSubmitEvent $event): void
    {
        $formData = $event->getData();
        $form = $event->getForm();
        if(isset($formData['addUser'])&& $formData['adduser']=="1") {

            $form->add('user', UserType::class, [
                'label'=>false,
                'attr'=>[],
            ]);
            
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.pre_submit' => 'onFormPreSubmit',
            'form.pre_set_data' => 'onFormPreSetData',
        ];
    }

    public function onFormPreSetData(PreSubmitEvent $event): void
    {
        // ...
    }
}
