<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Razoyo\CarProfile\Api\Data\CarInterface;
use Razoyo\CarProfile\Api\Data\CarSearchResultInterface;
use Razoyo\CarProfile\Api\Data\CarSearchResultInterfaceFactory;
use Razoyo\CarProfile\Api\CarRepositoryInterface;
use Razoyo\CarProfile\Model\ResourceModel\Car\CollectionFactory as CarCollectionFactory;
use Razoyo\CarProfile\Model\ResourceModel\Car\Collection;
use Razoyo\CarProfile\Model\ResourceModel\Car as CarsResource;

class CarRepository implements CarRepositoryInterface
{
    /**
     * @param CarsResource $resource
     * @param CarFactory $carFactory
     * @param CarCollectionFactory $carCollectionFactory
     * @param CarSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        private CarsResource $resource,
        private CarFactory $carFactory,
        private CarCollectionFactory $carCollectionFactory,
        private CarSearchResultInterfaceFactory $searchResultFactory
    ) {
    }

    /**
     * @param $id
     * @return CarInterface|Car
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $car = $this->carFactory->create();
        $this->resource->load($car, $id);
        if (! $car->getId()) {
            throw new NoSuchEntityException(__('Unable to find car with ID "%1"', $id));
        }
        return $car;
    }

    /**
     * @param $customerId
     * @return CarInterface
     * @throws NoSuchEntityException
     */
    public function getByCustomerId($customerId): CarInterface
    {
        $car = $this->carFactory->create();
        $this->resource->load($car, $customerId, 'customer_id');

        if (!$car->getId()) {
            throw new NoSuchEntityException(__('Unable to find car with customer ID "%1"', $customerId));
        }
        return $car;
    }

    /**
     * @param CarInterface $car
     * @return CarInterface
     * @throws AlreadyExistsException
     */
    public function save(CarInterface $car)
    {
        $this->resource->save($car);
        return $car;
    }

    /**
     * @param CarInterface $car
     * @return void
     * @throws \Exception
     */
    public function delete(CarInterface $car)
    {
        $this->resource->delete($car);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CarSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return CarSearchResultInterface
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
