<?php

namespace Aw\Test\Ui\DataProvider;

use Aw\Test\Model\ResourceModel\NewsModel\NewsCollectionFactory;
use Aw\Test\Model\ResourceModel\NewsModel\NewsCollection;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class NewsDataProvider extends ModifierPoolDataProvider
{
    /**
     * @var PoolInterface
     */
    private $pool;

    /**
     * @var NewsCollection
     */
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        PoolInterface $pool,
        NewsCollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->pool = $pool;
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $items = $modifier->modifyData($this->data);

            if ($items) {
                $this->data['items'] = $items;
            }
        }

        return $this->data;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }
}
