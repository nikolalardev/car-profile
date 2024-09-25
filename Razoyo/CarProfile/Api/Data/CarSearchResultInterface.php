<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CarSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Razoyo\CarProfile\Api\Data\CarInterface[]
     */
    public function getItems();

    /**
     * @param \Razoyo\CarProfile\Api\Data\CarInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
