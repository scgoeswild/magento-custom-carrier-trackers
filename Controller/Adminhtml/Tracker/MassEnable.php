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

use SimoneChinaglia\CustomCarrierTrackers\Model\Tracker;
use Magento\Framework\Exception\LocalizedException;

class MassEnable extends AbstractMassAction
{
    /**
     * @param  AbstractCollection $collection
     * @throws LocalizedException
     */
    protected function massAction($collection)
    {
        $count = 0;
        foreach ($collection as $tracker) {
            $trackerDataObject = $this->trackerRepository->getById($tracker->getTrackerId());
            $trackerDataObject->setIsActive(Tracker::STATUS_ENABLED);
            $this->trackerRepository->save($trackerDataObject);
            $count++;
        }

        if ($count) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been enabled.', $count));
        }
    }
}
