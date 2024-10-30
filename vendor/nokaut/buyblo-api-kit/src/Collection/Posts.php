<?php

namespace Nokaut\BuybloApiKit\Collection;


use Nokaut\BuybloApiKit\Entity\Posts\Metadata;

class Posts extends CollectionAbstract
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
     * @param Metadata $matadata
     */
    public function setMetadata($matadata)
    {
        $this->metadata = $matadata;
    }
}