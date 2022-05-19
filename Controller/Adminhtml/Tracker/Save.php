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
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\DataObjectHelper;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface as TrackerRepository;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterfaceFactory;
use SimoneChinaglia\CustomCarrierTrackers\Controller\Adminhtml\Tracker;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;

class Save extends Tracker
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var TrackerInterfaceFactory
     */
    private $trackerDataFactory;

    /**
     * @param Context                 $context
     * @param PageFactory             $resultPageFactory
     * @param TrackerRepository       $trackerRepository
     * @param DataPersistorInterface  $dataPersistor
     * @param DataObjectHelper        $dataObjectHelper
     * @param TrackerInterfaceFactory $trackerDataFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        TrackerRepository $trackerRepository,
        DataPersistorInterface $dataPersistor,
        DataObjectHelper $dataObjectHelper,
        TrackerInterfaceFactory $trackerDataFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->trackerDataFactory = $trackerDataFactory;
        parent::__construct($context, $resultPageFactory, $trackerRepository);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = (int) $this->getRequest()->getParam('tracker_id');
            if (empty($data['tracker_id'])) {
                $data['tracker_id'] = null;
            }
            try {
                $trackerDataObject = $id
                    ? $this->trackerRepository->getById($id)
                    : $this->trackerDataFactory->create();

                $this->dataObjectHelper->populateWithArray(
                    $trackerDataObject,
                    $data,
                    TrackerInterface::class
                );

                $tracker = $this->trackerRepository->save($trackerDataObject);
                $this->messageManager->addSuccessMessage(__('The carrier tracker has been saved.'));
                $this->dataPersistor->clear('custom_carrier_tracker');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['tracker_id' => $tracker->getTrackerId(), '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the carrier tracker.')
                );
            }

            $this->dataPersistor->set('custom_carrier_tracker', $data);
            return $resultRedirect->setPath('*/*/edit', ['tracker_id' => $this->getRequest()->getParam('tracker_id')]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
