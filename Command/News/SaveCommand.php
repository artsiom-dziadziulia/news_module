<?php

namespace Aw\Test\Command\News;

use Aw\Test\Api\Data\NewsInterface;
use Aw\Test\Model\NewsModel;
use Aw\Test\Model\NewsModelFactory;
use Aw\Test\Model\ResourceModel\NewsResource;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * Save News Command.
 */
class SaveCommand
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
     * Save News.
     *
     * @param NewsInterface $news
     *
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(NewsInterface $news): int
    {
        try {
            /** @var NewsModel $model */
            $model = $this->modelFactory->create();
            $model->addData($news->getData());
            $model->setHasDataChanges(true);

            if (!$model->getData(NewsInterface::NEWS_ID)) {
                $model->setData(NewsInterface::NEWS_ID, null);
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save News. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception,
                ]
            );
            throw new CouldNotSaveException(__('Could not save News.'));
        }

        return (int)$model->getData(NewsInterface::NEWS_ID);
    }
}
