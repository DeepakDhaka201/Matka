'use strict';

  function dataTable(){
  $(function() {
    
    var orderListingTable = $('#order-listing').DataTable();
    
    
    if (orderListingTable) {
        orderListingTable.destroy(); 
    }

    
    $('#order-listing').DataTable({
        "aLengthMenu": [
            [5, 10, 15, -1],
            [5, 10, 15, "All"]
        ],
        "iDisplayLength": 5,
        "language": {
            search: ""
        }
    });

    $('#order-listing').each(function() {
        var datatable = $(this);
        
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
});
  }