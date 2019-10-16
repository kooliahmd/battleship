<?php


namespace SnakeTn\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CorsListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        if($event->getRequest()->getMethod()=='DELETE'){
            $a=1;
        }
        if ($event->getRequest()->getMethod() !== 'OPTIONS') {
            return;
        }

        $event->setResponse($this->getPreflightResponse($event->getRequest()));
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', '*');
    }

    private function getPreflightResponse(Request $request): Response
    {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', $request->headers->get('Access-Control-Request-Headers'));
        $response->headers->set('Access-Control-Allow-Methods', ['DELETE','POST','GET','PATCH']);
        $response->headers->set('Access-Control-Max-Age', 60*60*60*24);
        return $response;
    }
}