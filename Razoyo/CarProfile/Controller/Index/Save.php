<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Controller\Index;

use Magento\Customer\Controller\AccountInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Razoyo\CarProfile\Api\Data\CarInterface;
use Razoyo\CarProfile\Api\Data\CarInterfaceFactory;
use Razoyo\CarProfile\Api\CarRepositoryInterface;
use Razoyo\CarProfile\Model\Api\Cars;

class Save implements AccountInterface, HttpPostActionInterface
{
    /**
     * @param Cars $carsApi
     * @param CarInterfaceFactory $carFactory
     * @param CarRepositoryInterface $carRepository
     * @param Session $customerSession
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        private Cars $carsApi,
        private CarInterfaceFactory $carFactory,
        private CarRepositoryInterface $carRepository,
        private Session $customerSession,
        private RequestInterface $request,
        private ResultFactory $resultFactory
    ) {
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $customerId = (int) $this->customerSession->getCustomerId();
        $postData = $this->request->getParams();

        try {
            $car = $this->carRepository->getByCustomerId($customerId);
        } catch (NoSuchEntityException $e) {
            /** @var CarInterface $car */
            $car = $this->carFactory->create();
        }

        $carId = (string) $postData['car_id'];
        $apiCarData = $this->carsApi->getCarById($carId);

        $car->setCarId($carId);
        $car->setMake($apiCarData["make"]);
        $car->setModel($apiCarData["model"]);
        $car->setPrice($apiCarData["price"]);
        $car->setYear($apiCarData["year"]);
        $car->setSeats($apiCarData["seats"]);
        $car->setMpg($apiCarData["mpg"]);
        $car->setImage($apiCarData["image"]);
        $car->setCustomerId($customerId);
        $this->carRepository->save($car);

        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $result->setPath('carlist');

        return $result;
    }
}
