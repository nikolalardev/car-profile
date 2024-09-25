<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Model\ResourceModel\Car;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Razoyo\CarProfile\Model\Cars as Model;
use Razoyo\CarProfile\Model\ResourceModel\Car as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'razoyo_cars_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
