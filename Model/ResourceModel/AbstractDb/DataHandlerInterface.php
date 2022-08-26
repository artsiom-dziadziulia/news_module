<?php
declare(strict_types=1);

namespace Aw\Test\Model\ResourceModel\AbstractDb;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

interface DataHandlerInterface
{
    /**
     * Process after save actions during save transaction
     *
     * @param AbstractModel $model
     * @return void
     * @throws LocalizedException
     */
    public function afterSave(AbstractModel $model): void;

    /**
     * Process after load actions
     *
     * @param AbstractModel $model
     * @return void
     * @throws LocalizedException
     */
    public function afterLoad(AbstractModel $model): void;
}
