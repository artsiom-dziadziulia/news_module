<?php

declare(strict_types=1);

namespace Aw\Test\Ui\Component\Form\News\Modifiers;

use Aw\Test\Command\News\Get;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class General implements ModifierInterface
{
    const NEWS_REQUEST_ID = 'news_id';

    /**
     * @var Get
     */
    private $getNews;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        Get $getNews,
        RequestInterface $request
    ) {
        $this->getNews = $getNews;
        $this->request = $request;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function modifyData(array $data): array
    {
        $data = [];
        $newsId = $this->request->getParam(self::NEWS_REQUEST_ID);

        if ($newsId) {
            $news = $this->getNews->execute((int)$newsId);
            $data[$newsId][] = $news->getData();
            $data[$newsId][0]['status'] = (string)$data[$newsId][0]['status'];
        }

        if (!empty($data[$newsId])) {
            $data = $data[$newsId];
        }

        return $data;
    }

    /**
     * @param array $meta
     *
     * @return array
     */
    public function modifyMeta(array $meta): array
    {
        return $meta;
    }
}
