<?php

namespace BuybloBox\Utils\Pagination;


class Pagination
{
    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $delta = 4;

    /**
     * @var string
     */
    private $urlTemplate;

    /**
     * @var string
     */
    private $urlFirstPage;

    /**
     * @param int $pageNumber
     */
    public function setCurrentPage($pageNumber)
    {
        $pageNumber = intval($pageNumber);
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        if ($pageNumber > $this->total) {
            $pageNumber = $this->total;
        }
        $this->currentPage = $pageNumber;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getLastPageNum()
    {
        return $this->getTotal();
    }

    /**
     * @return int
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }

    /**
     * @param string $urlTemplate
     */
    public function setUrlTemplate($urlTemplate)
    {
        $this->urlTemplate = urldecode($urlTemplate);
    }

    /**
     * @return string
     */
    public function getUrlFirstPage()
    {
        return $this->urlFirstPage;
    }

    /**
     * @param string $urlFirstPage
     */
    public function setUrlFirstPage($urlFirstPage)
    {
        $this->urlFirstPage = $urlFirstPage;
    }

    /**
     * @return bool
     */
    public function isFirstPage()
    {
        if ($this->currentPage == 1) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isLastPage()
    {
        return $this->total == $this->currentPage;
    }

    /**
     * @return array
     */
    public function getDeltaPagesNum()
    {
        $middleNumber = $this->calculateMiddleNumber();
        $lastPageNum = $this->total;

        if (($this->currentPage - $middleNumber < 0) || ($this->delta >= $lastPageNum)) {
            return $this->getPutOrderPageNumbers(1);
        }
        if ($this->currentPage + $middleNumber > $lastPageNum) {
            return $this->getPutOrderPageNumbers($lastPageNum - $this->delta + 1);
        }

        return $this->getPutOrderPageNumbers($this->currentPage - $middleNumber + 1);
    }

    /**
     * @param int $numberFrom
     * @return array
     */
    private function getPutOrderPageNumbers($numberFrom)
    {
        $result = array();

        $increasesLimit = min($this->delta, $this->total);
        for ($i = 0; $i < $increasesLimit; ++$i) {
            $result[] = $numberFrom + $i;
        }

        return $result;
    }

    /**
     * @param int $pageNumber
     * @return string
     */
    public function getPageUrl($pageNumber)
    {
        if ($pageNumber == 1 and $this->getUrlFirstPage()) {
            return $this->getUrlFirstPage();
        } else {
            return str_replace("%d", $pageNumber, $this->urlTemplate);
        }
    }

    /**
     * @return float|int
     */
    private function calculateMiddleNumber()
    {
        $half = $this->delta / 2;
        if ($this->delta % 2) {
            return floor($half) + 1;
        }
        return $half;
    }

    /**
     * @return bool
     */
    public function showLastPage()
    {
        $lastPageNum = $this->total;
        return $this->currentPage <= ($lastPageNum - $this->calculateMiddleNumber()) && $this->delta < $lastPageNum;
    }

    /**
     * @return bool
     */
    public function showFirstPage()
    {
        $lastPageNum = $this->total;
        return $this->currentPage > $this->calculateMiddleNumber() && $this->delta < $lastPageNum;
    }
} 