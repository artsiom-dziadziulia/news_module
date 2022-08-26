<?php

declare(strict_types=1);

namespace Aw\Test\Api;

/**
 * News search criteria scope processor
 */
interface NewsScopeProcessorInterface
{
    /**
     * Process Scope Search Criteria.
     * Add scope filters.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     */
    public function processSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): void;
}
