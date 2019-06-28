<?php

namespace SnakeTn\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ViewResponseListener
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        if ($controllerResult === null) {
            $event->setResponse(new Response(null));
            return;
        }
        $json = $this->serializer->serialize($controllerResult,'json');
        $event->setResponse(new JsonResponse($json, Response::HTTP_OK, [], true));
    }
}