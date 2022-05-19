<?php
/**
 * SimoneChinaglia Custom Carrier Trackers Extension
 *
 * @category  SimoneChinaglia
 * @package   SimoneChinaglia_CustomCarrierTrackers
 * @author    Simone Chinaglia
 * @copyright Copyright (c) 2022 SimoneChinaglia (https://www.simonechinaglia.com)
 * @license   LICENSE_MV.txt or https://www.simonechinaglia.com/license-agreement/
 */
declare(strict_types=1);

namespace SimoneChinaglia\CustomCarrierTrackers\Controller\Adminhtml\Tracker;

use SimoneChinaglia\CustomCarrierTrackers\Controller\Adminhtml\Tracker;
use Magento\Backend\Model\View\Result\Page;

class Index extends Tracker
{
    /**
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('SimoneChinaglia_CustomCarrierTrackers::custom_carrier_trackers')
            ->getConfig()->getTitle()->prepend(__('Gestione vettori'));

        return $resultPage;
    }
}
