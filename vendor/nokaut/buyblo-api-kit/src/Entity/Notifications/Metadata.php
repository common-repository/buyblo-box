<?php

namespace Nokaut\BuybloApiKit\Entity\Notifications;


use Nokaut\BuybloApiKit\Entity\EntityAbstract;

class Metadata extends EntityAbstract
{
    /**
     * @var int|null
     */
    protected $total;

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
}