<?php
/**
 * User: Technogex
 * Date: 3/17/2019
 * Time: 8:15 AM
 */

namespace Technogex\CustomerAttribute\Model\ResourceModel\Attribute\Grid;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Magento\Eav\Model\Entity as Entity;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{

    /**
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @param Entity $entityModel
     * @throws \Exception
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable,
        $resourceModel,
        Entity $entityModel
    ) {
        $this->entityModel = $entityModel;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * Init collection select
     *
     * @return Collection
     */
    protected function _initSelect()
    {
        $entityTypeId = $this->entityModel->setType(
            \Magento\Customer\Model\Customer::ENTITY
        )->getTypeId();

        parent::_initSelect();
        //Join eav attribute table
        $this->getSelect()->joinLeft(
            ['eav_attribute' => $this->getTable('eav_attribute')],
            'eav_attribute.attribute_id = main_table.attribute_id'
        );
        $this->getSelect()->where('eav_attribute.entity_type_id=?',$entityTypeId);

    }
}