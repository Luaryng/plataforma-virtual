<script>
    var defaultData = <?php echo json_encode($array);?>;
    var $checkableTree = $('#treeview-nodes').treeview({
        data: defaultData,
        showTags: true,
        selectable: true,
        showIcon: true,
        nodeIcon: 'far fa-folder-open',
        //showCheckbox: true,
        onNodeSelected: function(event, node) {
            $('#actxtitem').val(node.text);
            $('#actxtiditem').val(node.tags.id);
            $('#actxttipo').val(node.tags.tipo);
            $('#cbpadre').val(node.tags.idpadre);
        },
        onNodeUnselected: function(event, node) {
            $('#selectable-output').prepend('<p>' + node.text + ' was unselected</p>');
        }
    });
    $checkableTree.treeview('collapseAll', { silent: true });
</script>