<?php

namespace SnakeTn\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $body = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        if ($exception instanceof ServerExceptionInterface) {
            $content = json_decode($exception->getResponse()->getContent(false), true);
            $body = [
                'code' => $content['code'],
                'message' => $content['message'],
            ];
        }

        $response = new JsonResponse($body, $this->resolveResponseCode($exception));
        $event->setResponse($response);
    }

    private function resolveResponseCode(\Exception $exception)
    {
        if ($exception instanceof \InvalidArgumentException) {
            return Response::HTTP_BAD_REQUEST;
        }
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}