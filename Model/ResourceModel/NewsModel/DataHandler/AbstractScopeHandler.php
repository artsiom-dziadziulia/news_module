<?php
declare(strict_types=1);

namespace Aw\Test\Model\ResourceModel\NewsModel\DataHandler;

use Aw\Test\Api\Data\NewsInterface;
use Aw\Test\Api\NewsStoreDataInterface;
use Aw\Test\Model\ResourceModel\AbstractDb\DataHandlerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Model\AbstractModel;

class AbstractScopeHandler implements DataHandlerInterface
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var string
     */
    private $scopeValueColumn;

    /**
     * @var string
     */
    private $scopeValuesDataKey;

    /**
     * @var int|mixed
     */
    private $allScopesValue;

    public function __construct(
        ResourceConnection $resourceConnection,
        string $tableName = '',
        string $scopeValueColumn = '',
        string $scopeValuesDataKey = '',
        $allScopesValue = ''
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->tableName = $tableName;
        $this->scopeValueColumn = $scopeValueColumn;
        $this->scopeValuesDataKey = $scopeValuesDataKey;
        $this->allScopesValue = $allScopesValue;
    }

    /**
     * @param AbstractModel|NewsInterface $model
     * @return void
     */
    public function afterSave(AbstractModel $model): void
    {
        $newsId = (int)$model->getNewsId();
        $scopeValues = (array)$model->getData($this->scopeValuesDataKey);

        if (in_array($this->allScopesValue, $scopeValues) || empty($scopeValues)) {
            // Delete all scope values == selected ALL
            $this->deleteScopeValues($newsId);
            return;
        }

        $existed = $this->getScopeValues($newsId);
        $toInsert = array_diff($scopeValues, $existed);
        $toDelete = array_diff($existed, $scopeValues);

        if (!empty($toDelete)) {
            $this->deleteScopeValues($newsId, $toDelete);
        }

        if (!empty($toInsert)) {
            $this->saveScopeValues($newsId, $toInsert);
        }
    }

    /**
     * @param AbstractModel|NewsInterface $model
     * @return void
     */
    public function afterLoad(AbstractModel $model): void
    {
        $newsId = (int)$model->getNewsId();

        if ($newsId) {
            $model->setData($this->scopeValuesDataKey, $this->getScopeValues($newsId));
        }
    }

    /**
     * @param int $newsId
     * @param array $cols
     * @return array
     */
    private function getScopeValues(int $newsId, array $cols = []): array
    {
        $cols = empty($cols) ? [$this->scopeValueColumn] : $cols;
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()
            ->from($this->resourceConnection->getTableName($this->tableName), $cols)
            ->where(NewsStoreDataInterface::NEWS_ITEM_ID . ' = ?', $newsId);

        return empty($cols)
            ? (array)$connection->fetchAll($select)
            : (array)$connection->fetchCol($select);
    }

    /**
     * @param int $newsId
     * @param array $scopeValues
     * @return void
     */
    private function deleteScopeValues(int $newsId, array $scopeValues = []): void
    {
        $connection = $this->resourceConnection->getConnection();
        $where = [NewsStoreDataInterface::NEWS_ITEM_ID . ' = ?' => $newsId];

        if (!empty($scopeValues)) {
            $where[$this->scopeValueColumn . ' IN(?)'] = $scopeValues;
        }
        $connection->delete(
            $this->resourceConnection->getTableName($this->tableName),
            $where
        );
    }

    /**
     * @param int $newsId
     * @param array $scopeValues
     * @return void
     */
    private function saveScopeValues(int $newsId, array $scopeValues): void
    {
        $connection = $this->resourceConnection->getConnection();
        $insertArray = [];
        foreach ($scopeValues as $scopeValue) {
            $insertArray[] = [
                $newsId,
                $scopeValue
            ];
        }
        $connection->insertArray(
            $this->resourceConnection->getTableName($this->tableName),
            [
                NewsStoreDataInterface::NEWS_ITEM_ID,
                $this->scopeValueColumn
            ],
            $insertArray
        );
    }
}
