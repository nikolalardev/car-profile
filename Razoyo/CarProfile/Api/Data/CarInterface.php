<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Api\Data;

interface CarInterface
{
    public const ENTITY_ID = 'entity_id';
    public const CAR_ID = 'car_id';
    public const YEAR = 'year';
    public const MAKE = 'make';
    public const MODEL = 'model';

    public const PRICE = 'price';
    public const SEATS = 'seats';
    public const MPG = 'mpg';
    public const IMAGE = 'image';

    public const CUSTOMER_ID = 'customer_id';

    /**
     * Return the Entity ID
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set Entity ID
     *
     * @param int $id
     * @return $this
     */
    public function setEntityId($id);

    /**
     * @return int
     */
    public function getCarId();

    /**
     * @param int $id
     * @return void
     */
    public function setCarId($id);

    /**
     * @return string
     */
    public function getMake();

    /**
     * @param string $make
     * @return void
     */
    public function setMake($make);

    /**
     * @return string
     */
    public function getModel();

    /**
     * @param string $model
     * @return void
     */
    public function setModel($model);

    /**
     * @return float
     */
    public function getPrice();

    /**
     * @param float $price
     * @return void
     */
    public function setPrice($price);

    /**
     * @return int
     */
    public function getYear();

    /**
     * @param int $year
     * @return void
     */
    public function setYear($year);

    /**
     * @return int
     */
    public function getSeats();

    /**
     * @param int $seats
     * @return void
     */
    public function setSeats($seats);

    /**
     * @return int
     */
    public function getMpg();

    /**
     * @param int $mpg
     * @return void
     */
    public function setMpg($mpg);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     * @return void
     */
    public function setImage($image);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $id
     * @return void
     */
    public function setCustomerId($customerId);
}
