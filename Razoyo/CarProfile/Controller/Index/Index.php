<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Controller\Index;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index implements AccountInterface, HttpGetActionInterface
{
    /**
     * @param PageFactory $pageFactory
     */
    public function __construct(
        private PageFactory $pageFactory,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}

