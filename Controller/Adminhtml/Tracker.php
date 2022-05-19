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

namespace SimoneChinaglia\CustomCarrierTrackers\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface as TrackerRepository;
use Magento\Backend\Model\View\Result\Page;

abstract class Tracker extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'SimoneChinaglia_CustomCarrierTrackers::custom_carrier_trackers';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var TrackerRepository
     */
    protected $trackerRepository;

    /**
     * @param Context           $context
     * @param PageFactory       $resultPageFactory
     * @param TrackerRepository $trackerRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        TrackerRepository $trackerRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->trackerRepository = $trackerRepository;
        parent::__construct($context);
    }

    /**
     * @param  Page $resultPage
     * @return Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('SimoneChinaglia_CustomCarrierTrackers::simonechinaglia')
            ->addBreadcrumb(__('Gestione vettori'), __('Gestione vettori'))
            ->addBreadcrumb(__('Gestione vettori'), __('Gestione vettori'));
        return $resultPage;
    }
}
