<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Model;

use Magento\Framework\Model\AbstractModel;
use Razoyo\CarProfile\Api\Data\CarInterface;
use Razoyo\CarProfile\Model\ResourceModel\Car as ResourceModel;

class Car extends AbstractModel implements CarInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'razoyo_cars_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getCarId()
    {
        return $this->getData(self::CAR_ID);
    }

    public function setCarId($id)
    {
        $this->setData(self::CAR_ID, $id);
    }

    public function getMake()
    {
        return $this->getData(self::MAKE);
    }

    public function setMake($make)
    {
        $this->setData(self::MAKE, $make);
    }

    public function getModel()
    {
        return $this->getData(self::MODEL);
    }

    public function setModel($model)
    {
        $this->setData(self::MODEL, $model);
    }

    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    public function setPrice($price)
    {
        $this->setData(self::PRICE, $price);
    }

    public function getYear()
    {
        return $this->getData(self::YEAR);
    }

    public function setYear($year)
    {
        $this->setData(self::YEAR, $year);
    }

    public function getSeats()
    {
        return $this->getData(self::SEATS);
    }

    public function setSeats($seats)
    {
        $this->setData(self::SEATS, $seats);
    }

    public function getMpg()
    {
        return $this->getData(self::MPG);
    }

    public function setMpg($mpg)
    {
        $this->setData(self::MPG, $mpg);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function setImage($image)
    {
        $this->setData(self::IMAGE, $image);
    }

    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomerId($customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
