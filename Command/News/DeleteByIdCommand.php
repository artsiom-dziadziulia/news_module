<?php

namespace Aw\Test\Command\News;

use Aw\Test\Api\Data\NewsInterface;
use Aw\Test\Model\NewsModel;
use Aw\Test\Model\NewsModelFactory;
use Aw\Test\Model\ResourceModel\NewsResource;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Delete News by id Command.
 */
class DeleteByIdCommand
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var NewsModelFactory
     */
    private $modelFactory;

    /**
     * @var NewsResource
     */
    private $resource;

    /**
     * @param LoggerInterface $logger
     * @param NewsModelFactory $modelFactory
     * @param NewsResource $resource
     */
    public function __construct(
        LoggerInterface $logger,
        NewsModelFactory $modelFactory,
        NewsResource $resource
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
    }

    /**
     * Delete News.
     *
     * @param int $entityId
     *
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $entityId): void
    {
        try {
            /** @var NewsModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, NewsInterface::NEWS_ID);

            if (!$model->getData(NewsInterface::NEWS_ID)) {
                throw new NoSuchEntityException(
                    __(
                        'Could not find News with id: `%id`',
                        [
                            'id' => $entityId,
                        ]
                    )
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete News. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception,
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete News.'));
        }
    }
}
