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

use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

use SimoneChinaglia\CustomCarrierTrackers\Controller\Adminhtml\Tracker;

class Edit extends Tracker
{
    /**
     * Edit Carrier Tracker
     *
     * @return Page|Redirect
     * @throws LocalizedException
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('tracker_id');
        if ($id) {
            try {
                $tracker = $this->trackerRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while editing the custom carrier tracker.')
                );
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('SimoneChinaglia_CustomCarrierTrackers::custom_carrier_trackers')
            ->getConfig()->getTitle()->prepend(
                $id ? $tracker->getCarrierTitle() : __('New Carrier Tracker')
            );

        return $resultPage;
    }
}
