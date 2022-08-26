<?php

declare(strict_types=1);

namespace Aw\Test\Command\News;

use Aw\Test\Api\Data\NewsSearchResultsInterface;
use Aw\Test\Api\Data\NewsSearchResultsInterfaceFactory;
use Aw\Test\Model\ResourceModel\NewsModel\NewsCollection;
use Aw\Test\Model\ResourceModel\NewsModel\NewsCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class GetList
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var NewsCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var NewsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        NewsCollectionFactory $collectionFactory,
        NewsSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return NewsSearchResultsInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria): NewsSearchResultsInterface
    {
        /** @var NewsCollection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var NewsSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
