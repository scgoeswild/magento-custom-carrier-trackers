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

namespace SimoneChinaglia\CustomCarrierTrackers\Model\ResourceModel;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\EntityManager\EntityManager;
use SimoneChinaglia\CustomCarrierTrackers\Model\ResourceModel\Tracker\CollectionFactory;
use SimoneChinaglia\CustomCarrierTrackers\Model\TrackerRegistry;
use SimoneChinaglia\CustomCarrierTrackers\Model\Tracker as TrackerModel;
use SimoneChinaglia\CustomCarrierTrackers\Model\TrackerFactory;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterfaceFactory;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerSearchResultsInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerSearchResultsInterface;

class TrackerRepository implements TrackerRepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var TrackerFactory
     */
    protected $trackerFactory;

    /**
     * @var CollectionFactory
     */
    protected $trackerCollectionFactory;

    /**
     * @var TrackerSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var TrackerRegistry
     */
    protected $trackerRegistry;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var TrackerInterfaceFactory
     */
    protected $trackerDataFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param EntityManager                        $entityManager
     * @param TrackerFactory                       $trackerFactory
     * @param TrackerInterfaceFactory              $trackerDataFactory
     * @param TrackerSearchResultsInterfaceFactory $searchResultsFactory
     * @param TrackerRegistry                      $trackerRegistry
     * @param DataObjectHelper                     $dataObjectHelper
     * @param DataObjectProcessor                  $dataObjectProcessor
     */
    public function __construct(
        EntityManager $entityManager,
        TrackerFactory $trackerFactory,
        TrackerInterfaceFactory $trackerDataFactory,
        TrackerSearchResultsInterfaceFactory $searchResultsFactory,
        TrackerRegistry $trackerRegistry,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionFactory $trackerCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->entityManager = $entityManager;
        $this->trackerFactory = $trackerFactory;
        $this->trackerDataFactory = $trackerDataFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->trackerRegistry = $trackerRegistry;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->trackerCollectionFactory = $trackerCollectionFactory;
    }

    /**
     * Save custom carrier tracker data
     *
     * @param  TrackerInterface $tracker
     * @return TrackerInterface
     * @throws LocalizedException
     */
    public function save(TrackerInterface $tracker): TrackerInterface
    {
        $trackerModel = $this->trackerFactory->create();
        if ($trackerId = $tracker->getTrackerId()) {
            $this->entityManager->load($trackerModel, $trackerId);
        }
        $trackerModel->addData(
            $this->dataObjectProcessor->buildOutputDataArray($tracker, TrackerInterface::class)
        );

        $trackerModel->beforeSave();
        $this->entityManager->save($trackerModel);
        $tracker = $this->getTrackerDataObject($trackerModel);
        $this->trackerRegistry->push($tracker);
        return $tracker;
    }

    /**
     * Load custom carrier tracker data by given tracker id Identity
     *
     * @param  string $trackerId
     * @return TrackerModel
     * @throws NoSuchEntityException
     */
    public function getById($trackerId)
    {
        return $this->trackerRegistry->retrieve($trackerId);
    }

    /**
     * Load custom carrier tracker data collection by given search criteria
     *
     * @param  SearchCriteriaInterface $criteria
     * @return TrackerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->trackerCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());

        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * Delete Custom carrier tracker
     *
     * @param  TrackerInterface $tracker
     * @return bool
     * @throws NoSuchEntityException
     */
    public function delete(TrackerInterface $tracker): bool
    {
        return $this->deleteById($tracker->getTrackerId());
    }

    /**
     * Delete custom carrier tracker by given tracker Id Identity
     *
     * @param  string $trackerId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($trackerId): bool
    {
        $tracker = $this->trackerRegistry->retrieve($trackerId);
        $this->entityManager->delete($tracker);
        $this->trackerRegistry->remove($trackerId);
        return true;
    }

    /**
     * Retrieves tracker data object using Tracker Model
     *
     * @param  TrackerModel $tracker
     * @return TrackerInterface
     */
    protected function getTrackerDataObject(TrackerModel $tracker)
    {
        $trackerDataObject = $this->trackerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $trackerDataObject,
            $tracker->getData(),
            TrackerInterface::class
        );
        $trackerDataObject->setTrackerId($tracker->getTrackerId());

        return $trackerDataObject;
    }
}
