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
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends Tracker
{
    /**
     * @return Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int) $this->getRequest()->getParam('tracker_id');
        if ($id) {
            try {
                $this->trackerRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The carrier tracker has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['tracker_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a carrier tracker to delete.'));
        return $resultRedirect->setPath('*/*/index');
    }
}
