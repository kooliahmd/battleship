<?php


class Resource
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $location;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

}