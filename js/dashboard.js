$(function() {
  // Bootstrapping
  $('.message').css('display', 'none');
  $('.message').html('');
  views.updateAll();

  // Add Item
  $('#add-item-form').on('submit', handlers.forms.addItem);  
  $('#add-shop-form').on('submit', handlers.forms.addShop);  
  $('#add-invoice-form').on('submit', handlers.forms.addInvoice);

  // Delete Forms
  $('#del-invoice-form').on('submit', handlers.forms.deleteInvoice);
  $('#del-item-form').on('submit', handlers.forms.deleteItem);
  $('#del-shop-form').on('submit', handlers.forms.deleteShop);

  // Invoice Details
  $('#item-to-add-id').on('focus', handlers.invoiceDetails.init);
  $('#item-to-add').on('click', handlers.invoiceDetails.addItem);
  $('#item-to-add-quantity').on('keyup', handlers.invoiceDetails.quantityChange);
  $('#item-to-add-price').on('keyup', handlers.invoiceDetails.priceChange);

  // Modals event handlers
  $('.delete-modal').on('show.bs.modal', handlers.modals.deleteShow);
  $('.delete-modal').on('hide.bs.modal', handlers.modals.deleteHide);
  $('.edit-modal').on('show.bs.modal', handlers.modals.editShow);
  $('.edit-modal').on('hide.bs.modal', handlers.modals.editHide);
});
function renderTable(data, ignore, $targets) {
  if(!data || data.length === 0) { return "<h3 class='text-center'>:( Nothing to show.</h3>"; }

  ignore = ignore || [];
  var html = "<table class='table table-striped table-hover'>";
  var headers = "<thead> <tr>";
  var rows = "";

  for(var i in data[0]) {
    if(ignore.indexOf(i) < 0) {
      headers += ("<th>" + i.toUpperCase() + "</th>");
    } 
  } 
  if($targets) {
    html += (headers + '<th>Operations</th></tr></thead><tbody>');
  } else {
    html += (headers + '</tr></thead><tbody>');
  }

  for(i = 0; i < data.length; i++) {
    rows += '<tr>';
    for(j in data[i]) {
      if(ignore.indexOf(j) < 0) {
        rows += ('<td>' + data[i][j] + '</td>');
      } 
    }
    if($targets) {
      rows += '<td>';
      // TODO: need to fix this somehow
      if($targets.update) {
        rows += '<button class="btn btn-xs btn-info edit-button" data-id="' + (data[i].item_id | data[i].shop_id | data[i].invoice_id) + '" data-toggle="modal" data-target="#' + $targets.update.attr('id') + '">Edit</button>';
      }
      if($targets.del) {
        rows += '<button class="btn btn-xs btn-danger delete-button" data-id="' + (data[i].item_id | data[i].shop_id | data[i].invoice_id) + '" data-toggle="modal" data-target="#' + $targets.del.attr('id') + '">Delete</button></td>';
      } 
    }
  }
  html += rows + ('</tr></tbody></table>');

  return html;
}
