<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Razoyo\CarProfile\Api\Data\CarInterface;

interface CarRepositoryInterface
{
    /**
     * @param int $id
     * @return \Razoyo\CarProfile\Api\Data\CarInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);


    /**
     * @param int $customerId
     * @return \Razoyo\CarProfile\Api\Data\CarInterface
     * @throw LocalizedException
     */
    public function getByCustomerId($customerId): CarInterface;

    /**
     * @param \Razoyo\CarProfile\Api\Data\CarInterface $car
     * @return \Razoyo\CarProfile\Api\Data\CarInterface
     */
    public function save(CarInterface $car);

    /**
     * @param \Razoyo\CarProfile\Api\Data\CarInterface $car
     * @return void
     */
    public function delete(CarInterface $car);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Razoyo\CarProfile\Api\Data\CarSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
