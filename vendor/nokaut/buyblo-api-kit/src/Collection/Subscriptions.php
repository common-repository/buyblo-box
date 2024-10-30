<?php

namespace Nokaut\BuybloApiKit\Collection;


use Nokaut\BuybloApiKit\Entity\Subscriptions\Metadata;

class Subscriptions extends CollectionAbstract
{
    /**
     * @var Metadata
     */
    protected $metadata;

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }
}