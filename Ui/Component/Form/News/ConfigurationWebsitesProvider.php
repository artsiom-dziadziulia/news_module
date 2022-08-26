<?php

declare(strict_types=1);

namespace Aw\Test\Ui\Component\Form\News;

class ConfigurationWebsitesProvider implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    private $systemStore;

    public function __construct(\Magento\Store\Model\System\Store $systemStore)
    {
        $this->systemStore = $systemStore;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->systemStore->getStoreValuesForForm();
    }
}
