<?php

namespace Aw\Test\Mapper;

use Aw\Test\Api\Data\NewsInterface;
use Aw\Test\Api\Data\NewsInterfaceFactory;
use Aw\Test\Model\NewsModel;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of News entities to an array of data transfer objects.
 */
class NewsDataMapper
{
    /**
     * @var NewsInterfaceFactory
     */
    private $entityDtoFactory;

    /**
     * @param NewsInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        NewsInterfaceFactory $entityDtoFactory
    ) {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|NewsInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var NewsModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var NewsInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
