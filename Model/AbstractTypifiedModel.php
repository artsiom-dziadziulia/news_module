<?php
declare(strict_types=1);

namespace Aw\Test\Model;

abstract class AbstractTypifiedModel extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Override set data for force typization
     *
     * @param string|array $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setData($key, $value = null)
    {
        parent::setData($key, $value);
        $idKey = $this->getIdFieldName();

        if ($key === (array)$key) {
            foreach ($this->_data as $key => &$value) {

                // Workaround to save new entities
                if ($key === $idKey && !$value) {
                    $value = null;
                    continue;
                }

                $value = $this->getDataUsingMethod($key);
            }
        }

        return $this;
    }

    /**
     * @param array $arr
     *
     * @return AbstractTypifiedModel
     */
    public function addData(array $arr)
    {
        parent::addData($arr);

        foreach ($this->_data as $key => &$value) {
            $value = $this->getDataUsingMethod($key);
        }

        return $this;
    }
}
