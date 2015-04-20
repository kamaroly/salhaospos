<?php
require_once("report.php");
class Inventory_summary extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_item_name'), $this->lang->line('reports_item_number'), $this->lang->line('reports_description'), $this->lang->line('reports_count'),$this->lang->line('reports_items_cost_price'),$this->lang->line('reports_items_unit_price'),$this->lang->line('reports_items_whole_price'), $this->lang->line('reports_reorder_level'),$this->lang->line('reports_stock_location'));
	}
	
	public function getData(array $inputs,$supplier=0,$category=null)
	{
	    $this->db->from('items');		
        $this->db->join('item_quantities','items.item_id=item_quantities.item_id');
        $this->db->join('stock_locations','item_quantities.location_id=stock_locations.location_id');
        
		$this->db->select('name, item_number, reorder_level, item_quantities.quantity,cost_price,unit_price,whole_price, description,location_name');
		$this->db->where('items.deleted', 0);	
		///////////////////////////////////////////////////////////////////////////////////
        // Added by Kamaro Lambert kamaroly@gmail.com to filter by supplier and category //
        ///////////////////////////////////////////////////////////////////////////////////
        if((bool) $supplier)
        {
        	$this->db->where('items.supplier_id ='.$supplier);
        }

          if(!is_null($category) )
        {
        	$this->db->where(" TRIM(LOWER(".$this->db->dbprefix('items').".category))", "'".$category."'",FALSE);
        
        }
		$this->db->order_by('items.name');
		
		return $this->db->get()->result_array();

	}
	
	public function getSummaryData(array $inputs,$supplier=0,$category=null)
	{
		$this->db->from('items');		
        $this->db->join('item_quantities','items.item_id=item_quantities.item_id');
        $this->db->join('stock_locations','item_quantities.location_id=stock_locations.location_id');
        
		$this->db->select('sum('.$this->db->dbprefix('item_quantities').'.quantity) as total_quantity,sum('.$this->db->dbprefix('item_quantities').'.quantity)*cost_price as total_cost_price,sum('.$this->db->dbprefix('item_quantities').'.quantity)*unit_price as total_unit_price,sum('.$this->db->dbprefix('item_quantities').'.quantity)*whole_price as total_whole_price');
       $this->db->where('items.deleted', 0);	
		        if((bool) $supplier)
        {
        	$this->db->where('items.supplier_id ='.$supplier);
        }

          if(!is_null($category) )
        {
        	$this->db->where(" TRIM(LOWER(".$this->db->dbprefix('items').".category))", "'".$category."'",FALSE);
        
        }
		
		return $this->db->get()->row_array();
	}
}
?>