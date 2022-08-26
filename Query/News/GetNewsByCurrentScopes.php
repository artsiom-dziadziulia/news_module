<?php

declare(strict_types=1);

namespace Aw\Test\Query\News;

use Aw\Test\Api\Data\NewsSearchResultsInterface;
use Aw\Test\Command\News\GetList;
use Magento\Framework\Api\Search\SearchCriteriaFactory;

class GetNewsByCurrentScopes
{
    /**
     * @var GetList
     */
    private $getList;

    /**
     * @var SearchCriteriaFactory
     */
    private $searchCriteriaFactory;

    /**
     * @var \Aw\Test\Api\NewsScopeProcessorInterface[]
     */
    private $scopeProcessors;

    public function __construct(
        GetListQuery $getList,
        SearchCriteriaFactory $searchCriteriaFactory,
        array $scopeProcessors = []
    ) {
        $this->getList = $getList;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
        $this->scopeProcessors = $scopeProcessors;
    }

    /**
     * @return \Magento\Framework\Api\SearchResults
     */
    public function execute(): \Magento\Framework\Api\SearchResults
    {
        $searchCriteria = $this->searchCriteriaFactory->create();
        foreach ($this->scopeProcessors as $processor) {
            $processor->processSearchCriteria($searchCriteria);
        }

        return $this->getList->execute($searchCriteria);
    }
}
