<?php
namespace Blackbird\TicketBlaster\Ui\Component\Listing\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class prepare Page Actions
 */
class EventActions extends Column
{
    /** Url path */
    const EVENT_URL_PATH_EDIT = 'ticketblaster/event/edit';
    const EVENT_URL_PATH_DELETE = 'ticketblaster/event/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Escaper
     */
    private $escaper;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['event_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::EVENT_URL_PATH_EDIT, ['event_id' => $item['event_id']]),
                        'label' => __('Edit'),
                    ];
//                    $title = $this->getEscaper()->escapeHtml($item['title']);
//                    $item[$name]['delete'] = [
//                        'href' => $this->urlBuilder->getUrl(self::EVENT_URL_PATH_DELETE, ['event_id' => $item['event_id']]),
//                        'label' => __('Delete'),
//                        'confirm' => [
//                            'title' => __('Delete %1', $title),
//                            'message' => __('Are you sure you want to delete a %1 record?', $title),
//                        ],
//                        'post' => true,
//                    ];
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get instance of escaper
     *
     * @return Escaper
     * @deprecated 101.0.7
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
