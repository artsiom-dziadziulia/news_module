<?php

declare(strict_types=1);

namespace Aw\Test\Model;

use Aw\Test\Api\NewsScopeProcessorInterface;
use Aw\Test\Model\Data\NewsStoreData;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class StoreScopeProcessor implements NewsScopeProcessorInterface
{

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     */
    public function processSearchCriteria(SearchCriteriaInterface $searchCriteria): void
    {
        $groups = $searchCriteria->getFilterGroups();

        $storeId = $this->storeManager->getStore()->getStoreId();

        $scope = $this->filterBuilder
            ->setField(NewsStoreData::SCOPE_ID)
            ->setValue($storeId)
            ->create();
        $noScope = $this->filterBuilder->setConditionType('null')
            ->setField(NewsStoreData::SCOPE_ID)
            ->setValue(true)
            ->create();

        //filters in one group separated by logical OR
        $groups[] = $this->filterGroupBuilder->addFilter($scope)->addFilter($noScope)->create();

        $searchCriteria->setFilterGroups($groups);
    }
}
