<?php

namespace Aw\Test\Model\ResourceModel;

use Aw\Test\Model\ResourceModel\AbstractDb\CompositeHandler;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class NewsResource extends AbstractDb
{
    public const MAIN_TABLE = 'news';
    public const SCOPE_STORE_TABLE = 'news_store';

    public const SKIP_HANDLERS = 'skip_handlers';

    /**
     * @var CompositeHandler
     */
    private $dataHandler;

    public function __construct(
        Context $context,
        CompositeHandler $dataHandler,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->dataHandler = $dataHandler;
    }

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, 'news_id');
    }

    protected function _afterSave(AbstractModel $object): self
    {
        if (!$object->getData(self::SKIP_HANDLERS)) {
            $this->dataHandler->afterSave($object);
        }

        return parent::_afterSave($object);
    }

    protected function _afterLoad(AbstractModel $object): self
    {
        $this->dataHandler->afterLoad($object);

        return parent::_afterLoad($object);
    }
}
