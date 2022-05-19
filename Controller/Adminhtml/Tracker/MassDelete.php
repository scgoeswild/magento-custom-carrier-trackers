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

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class MassDelete extends AbstractMassAction
{
    /**
     * @param  AbstractCollection $collection
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function massAction($collection)
    {
        $trackersDeleted = 0;
        foreach ($collection->getAllIds() as $trackerId) {
            $this->trackerRepository->deleteById($trackerId);
            $trackersDeleted++;
        }

        if ($trackersDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $trackersDeleted)
            );
        }
    }
}
