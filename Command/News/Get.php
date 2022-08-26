<?php

declare(strict_types=1);

namespace Aw\Test\Command\News;

use Aw\Test\Api\Data\NewsInterface;
use Aw\Test\Api\Data\NewsInterfaceFactory;
use Aw\Test\Model\ResourceModel\NewsResource;
use Magento\Framework\Exception\NoSuchEntityException;

class Get
{
    /**
     * @var NewsResource
     */
    private $resourceModel;

    /**
     * @var NewsInterfaceFactory
     */
    private $modelFactory;

    /**
     * @var array
     */
    private $storage = [];

    public function __construct(
        NewsInterfaceFactory $modelFactory,
        NewsResource $resourceModel
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * @param Int $itemId
     * @return NewsInterface
     */
    public function execute(Int $itemId): NewsInterface
    {
        if (!isset($this->storage[$itemId])) {
            /** @var NewsInterface $modelData */
            $modelData = $this->modelFactory->create();
            $this->resourceModel->load($modelData, $itemId);

            if ($itemId !== $modelData->getNewsId()) {
                throw new NoSuchEntityException(
                    __('News with ID "%value" does not exist.', ['value' => $itemId])
                );
            }

            $this->storage[$itemId] = $modelData;
        }

        return $this->storage[$itemId];
    }

    /**
     * @param int|null $itemId
     */
    public function clearStorage(?int $itemId): void
    {
        if ($itemId !== null) {
            unset($this->storage[$itemId]);
        } else {
            $this->storage = [];
        }
    }
}
