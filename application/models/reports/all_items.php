<?php
require_once("report.php");
class All_items extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array('name','description','category','Quantity','cost price','unit price','whole price','reorder level','supplier id','allow alt description','is serialized','custom1','custom2','custom3','custom4','custom5','custom6','custom7','custom8','custom9','custom10','item number','location id','Taxes');
	}
	
	public function getData(array $inputs,$supplier=0,$category=null)
	{
	    $this->db->from('items');		
        $this->db->join('item_quantities','items.item_id=item_quantities.item_id');
        $this->db->join('stock_locations','item_quantities.location_id=stock_locations.location_id');
       
		$this->db->select('items.item_id,name,description,category,item_quantities.quantity,cost_price,unit_price,whole_price,reorder_level,supplier_id,allow_alt_description,is_serialized,custom1,custom2,custom3,custom4,custom5,custom6,custom7,custom8,custom9,custom10,item_number,item_quantities.location_id,item_quantities.quantity');
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
	
	public function getSummaryData(array $inputs)
	{
		return array();
	}
}
?>