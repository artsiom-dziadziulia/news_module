<?php

namespace Aw\Test\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor\JoinProcessor\CustomJoinInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Search criteria join processor.
 * Copied for fix different collection processing in one request
 */
class JoinProcessor implements CollectionProcessorInterface
{
    /**
     * @var CustomJoinInterface[]
     */
    private $joins;

    /**
     * @var array
     */
    private $fieldMapping;

    /**
     * @param CustomJoinInterface[] $customJoins
     * @param array $fieldMapping
     */
    public function __construct(
        array $customJoins = [],
        array $fieldMapping = []
    ) {
        $this->joins = $customJoins;
        $this->fieldMapping = $fieldMapping;
    }

    /**
     * Apply Search Criteria Filters to collection only if we need this
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param AbstractDb $collection
     * @return void
     */
    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        if ($searchCriteria->getFilterGroups()) {
            //Process filters
            foreach ($searchCriteria->getFilterGroups() as $group) {
                foreach ($group->getFilters() as $filter) {
                    if ($collection->getFlag('joined_' . $filter->getField()) === null) {
                        $this->applyCustomJoin($filter->getField(), $collection);
                        $collection->setFlag('joined_' . $filter->getField(), true);
                    }
                }
            }
        }
    }

    /**
     * Apply join to collection
     *
     * @param string $field
     * @param AbstractDb $collection
     * @return void
     */
    private function applyCustomJoin($field, AbstractDb $collection)
    {
        $field = $this->getFieldMapping($field);
        $customJoin = $this->getCustomJoin($field);

        if ($customJoin) {
            $customJoin->apply($collection);
        }
    }

    /**
     * Return custom filters for field if exists
     *
     * @param string $field
     * @return CustomJoinInterface|null
     * @throws \InvalidArgumentException
     */
    private function getCustomJoin($field)
    {
        $filter = null;
        if (isset($this->joins[$field])) {
            $filter = $this->joins[$field];
            if (!($this->joins[$field] instanceof CustomJoinInterface)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Custom join for %s must implement %s interface.',
                        $field,
                        CustomJoinInterface::class
                    )
                );
            }
        }
        return $filter;
    }

    /**
     * Return mapped field name
     *
     * @param string $field
     * @return string
     */
    private function getFieldMapping($field)
    {
        return $this->fieldMapping[$field] ?? $field;
    }
}
