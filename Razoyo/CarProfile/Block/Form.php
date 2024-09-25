<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Block;

use Magento\Framework\View\Element\Template;

class Form extends Template
{
    public function getFormAction()
    {
        return $this->getUrl('carlist/index/save');
    }
}
