<?php
declare(strict_types=1);

namespace Aw\Test\Model\ResourceModel\AbstractDb;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class CompositeHandler implements DataHandlerInterface
{
    /**
     * @var DataHandlerInterface[]
     */
    private $handlers;

    public function __construct(
        array $handlers = []
    ) {
        $this->handlers = $handlers;
    }

    /**
     * @param AbstractModel $model
     * @return void
     * @throws LocalizedException
     * @throws \InvalidArgumentException
     */
    public function afterSave(AbstractModel $model): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler instanceof DataHandlerInterface) {
                $handler->afterSave($model);
            } else {
                throw new \InvalidArgumentException(
                    'Type "' . get_class($handler) . '" is not instance on ' . DataHandlerInterface::class
                );
            }
        }
    }

    /**
     * @param AbstractModel $model
     * @return void
     * @throws LocalizedException
     * @throws \InvalidArgumentException
     */
    public function afterLoad(AbstractModel $model): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler instanceof DataHandlerInterface) {
                $handler->afterLoad($model);
            } else {
                throw new \InvalidArgumentException(
                    'Type "' . get_class($handler) . '" is not instance on ' . DataHandlerInterface::class
                );
            }
        }
    }
}
