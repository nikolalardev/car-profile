<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Session;
use Razoyo\CarProfile\Api\CarRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Razoyo\CarProfile\Model\Api\Cars;

class CarProfile implements ArgumentInterface
{
    public function __construct(
        private Cars $carsApi,
        private MessageManagerInterface $messageManager,
        private ResultFactory $resultFactory,
        private CarRepositoryInterface $carRepository,
        private Session $customerSession,
    ) {
    }
    public function getCarPerCustomer()
    {

        $customerId = (int) $this->customerSession->getCustomerId();

        try {
            $car = $this->carRepository->getByCustomerId($customerId);
            return [
                "entity_id" => $car->getEntityId(),
                "id" => $car->getCarId(),
                "make" => $car->getMake(),
                "model" => $car->getModel(),
                "price" => $car->getPrice(),
                "year" => $car->getYear(),
                "seats" => $car->getSeats(),
                "mpg" => $car->getMpg(),
                "image" => $car->getImage(),
            ];
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addNoticeMessage(__('Please select car.'));
            $data = [];
        }

        return $data;
    }

    public function getCarOptions()
    {
        $data = [];
        $apiCarData = $this->carsApi->getCarList();

        foreach ($apiCarData as $car) {
            $data[] = [
                'value' => $car["id"],
                'label' => $car["make"] . ' ' . $car["model"],
            ];
        }

        return $data;
    }
}
