<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_report_input'); ?></div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
	<div>
		Export to Excel: <input type="radio" name="export_excel" id="export_excel_yes" value='1' /> Yes
		<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> No
	</div>

	<?php if(isset($suppliers) && array_count_values($suppliers) > 1): ?>	
		<div class="field_row clearfix">
		<?php echo form_label($this->lang->line('items_supplier').':', 'supplier'); ?>
			<div class='form_field'>
			<?php echo form_dropdown('supplier_id', $suppliers,null,'id="supplier"');?>
			</div>
		</div>
	<?php endif; ?>

		<?php if(isset($categories) && array_count_values($categories) > 1): ?>	
		<div class="field_row clearfix">
		<?php echo form_label('Category :', 'supplier'); ?>
			<div class='form_field'>
			<?php echo form_dropdown('category', $categories,null,'id="category"');?>
			</div>
		</div>
	<?php endif; ?>

<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report',
	'content'=>$this->lang->line('common_submit'),
	'class'=>'submit_button')
);
?>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	
	$("#generate_report").click(function()
	{
		var export_excel = 0;
		var category,supplier_id;
			category     = $( "#category option" ).filter(":selected").val();
			supplier_id  = $( "#supplier option" ).filter(":selected").val();
			
		if ($("#export_excel_yes").attr('checked'))
		{
			export_excel = 1;
		}
		
		window.location = window.location+'/' + export_excel+'/' + supplier_id+'/' + category;
	});	
});
</script>