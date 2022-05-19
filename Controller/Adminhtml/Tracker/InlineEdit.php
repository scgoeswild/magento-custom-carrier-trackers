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

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Backend\App\Action;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface as TrackerRepository;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Exception\LocalizedException;
use SimoneChinaglia\CustomCarrierTrackers\Model\Tracker;

class InlineEdit extends Action
{
    /**
     * @var TrackerRepository
     */
    private $trackerRepository;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @param Context           $context
     * @param TrackerRepository $trackerRepository
     * @param JsonFactory       $jsonFactory
     * @param DataObjectHelper  $dataObjectHelper
     */
    public function __construct(
        Context $context,
        TrackerRepository $trackerRepository,
        JsonFactory $jsonFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        parent::__construct($context);
        $this->trackerRepository = $trackerRepository;
        $this->jsonFactory = $jsonFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $trackerId) {
                    $tracker = $this->trackerRepository->getById($trackerId);
                    try {
                        $this->dataObjectHelper->populateWithArray(
                            $tracker,
                            $postItems[$trackerId],
                            TrackerInterface::class
                        );

                        $this->trackerRepository->save($tracker);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithTrackerId(
                            $tracker,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData(
            [
            'messages' => $messages,
            'error' => $error
            ]
        );
    }

    /**
     * Add tracker title to error message
     *
     * @param  TrackerInterface $tracker
     * @param  string           $errorText
     * @return string
     */
    protected function getErrorWithTrackerId(TrackerInterface $tracker, $errorText): string
    {
        return '[Tracker ID: ' . $tracker->getTrackerId() . '] ' . $errorText;
    }
}
