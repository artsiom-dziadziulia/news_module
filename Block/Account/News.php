<?php

namespace Aw\Test\Block\Account;

use Aw\Test\Query\News\GetNewsByCurrentScopes;
use Magento\Framework\View\Element\Template;

class News extends Template
{
    /**
     * @var GetNewsByCurrentScopes
     */
    private $getNewsByCurrentScopes;

    public function __construct(
        GetNewsByCurrentScopes $getNewsByCurrentScopes,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->getNewsByCurrentScopes = $getNewsByCurrentScopes;
    }

    public function getNews()
    {
        return $this->getNewsByCurrentScopes->execute()->getItems();
    }
}
