<?php
namespace Pilotstore\Producttabslider\Model\ResourceModel\Reports\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Sales\Model\Order;

/**
 * Product Most Sold Collection
 */
class Collection extends ProductCollection
{
    /**
     * Add Orders Count
     *
     * @param string $from
     * @param string $to
     * @return \Pilotstore\Producttabslider\Model\ResourceModel\Reports\Product\Collection
     */
    public function addOrdersCount($from='', $to='')
    {
        $connection = $this->getConnection();
		$this->getSelect()
			->join(
				['i' => $this->getTable('sales_order_item')],
				'e.entity_id = i.product_id',
				['ordered_qty' => 'SUM(i.qty_ordered)']
			)
			->join(
				['o' => $this->getTable('sales_order')],
				'o.entity_id = i.order_id AND ' . 
				$connection->quoteInto("o.state <> ?", Order::STATE_CANCELED),
				[]
			)			
			->where('i.parent_item_id IS NULL' )
			->group('e.entity_id')
			->order('ordered_qty ' . self::SORT_ORDER_DESC);

        if ($from != '' && $to != '') {
            $this->getSelect()
				->where('i.created_at >= ?', $from)
				->where('i.created_at <= ?', $to);
        }
        return $this;
    }
}
