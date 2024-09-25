<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Car extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'razoyo_cars_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('razoyo_cars', 'entity_id');
    }
}
