<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ViewResponseListener
{
    public function onKernelView(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        if ($controllerResult === null) {
            $event->setResponse(new Response(null));
            return;
        }
        $event->setResponse(new JsonResponse($controllerResult));
    }
}