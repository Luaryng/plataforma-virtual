<div id="treeview-checkable"  ></div>
<input type="hidden" id="ptxtuser" value="<?php echo $txtcoduser ?>">
<script>
	var defaultData=<?php echo json_encode($array);?>;
	var $checkableTree = $('#treeview-checkable').treeview({
	    data: defaultData,
	    showIcon: false,
	    showTags: true,
	    showCheckbox: true,
	    nodeIcon: 'far fa-folder-open',
	    onNodeChecked: function(event, node) {
	        //$('#checkable-output').prepend('<p>' + node.text + ' was checked</p>');
	    },
	    onNodeUnchecked: function(event, node) {
	        //$('#checkable-output').prepend('<p>' + node.text + ' was unchecked</p>');
	    }
	});
</script>

