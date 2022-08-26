<?php

declare(strict_types=1);

namespace Aw\Test\Plugin;

use Magento\Customer\Block\Account\Navigation;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CustomerAccountNavigationPlugin
{
    const PARENT_BLOCK = 'customer_account_navigation';
    const NEWS_BLOCK = 'customer-account-navigation-account-news';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param Navigation $subject
     * @return array
     */
    public function beforeGetLinks(Navigation $subject): array
    {
        $newsBlock = $subject->getLayout()->getChildBlock(self::PARENT_BLOCK, self::NEWS_BLOCK);
        if ($newsBlock) {
            $isEnabled = (bool)$this->scopeConfig->getValue(
                'aw_news/general/is_active',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            $title = $this->scopeConfig->getValue(
                'aw_news/general/title',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            $newsBlock->setData('label', $title);

            $subject->getLayout()->getBlock('page.main.title')->setPageTitle($title);

            if (!$isEnabled) {
                $subject->getLayout()->unsetChild(
                    self::PARENT_BLOCK,
                    self::NEWS_BLOCK
                );
            }
        }

        return [];
    }
}