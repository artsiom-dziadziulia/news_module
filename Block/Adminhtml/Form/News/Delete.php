<?php

namespace Aw\Test\Block\Adminhtml\Form\News;

use Aw\Test\Api\Data\NewsInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete entity button.
 */
class Delete extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Delete button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return $this->wrapButtonSettings(
            'Delete',
            'delete',
            sprintf(
                "deleteConfirm('%s', '%s')",
                __('Are you sure you want to delete this news?'),
                $this->getUrl(
                    '*/*/delete',
                    [NewsInterface::NEWS_ID => $this->getNewsId()]
                )
            ),
            [],
            20
        );
    }
}
