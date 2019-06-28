<?php


namespace SnakeTn\ApiBundle;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class RequestBodyConverter implements ParamConverterInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $object = $this->serializer->deserialize(
            $request->getContent(),
            $configuration->getClass(),
            $request->getContentType()
        );
        $request->attributes->set($configuration->getName(), $object);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getConverter() === 'snaketn.api.request_body_converter';
    }

}