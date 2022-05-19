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
use Magento\Backend\Model\View\Result\ForwardFactory;
use SimoneChinaglia\CustomCarrierTrackers\Controller\Adminhtml\Tracker;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface as TrackerRepository;
use Magento\Backend\Model\View\Result\Forward;

class NewAction extends Tracker
{
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * @param Context           $context
     * @param PageFactory       $resultPageFactory
     * @param TrackerRepository $trackerRepository
     * @param ForwardFactory    $resultForwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        TrackerRepository $trackerRepository,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $resultPageFactory, $trackerRepository);
    }

    /**
     * Forward to edit
     *
     * @return Forward
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
