// depends on service.js
var views = {
  showLoader : function() {
    $('.loading-bar').css('visibility', 'visible');
  },
  hideLoader : function() {
    // Server too fast, can't see the beautiful loading bar, added a delay
    setTimeout(function() { $('.loading-bar').css('visibility', 'hidden'); }, 1250);
  },
  items : function() {
    service.getItems({
      table : $('#items'),
      update : $('#edit-item'),
      del : $('#del-item'),
      option : $('#item-to-add-id')
    },['owner_id', 'item_id', 'image']);
  },
  shops : function() {
    service.getShops({
      table : $('#shops'), 
      update : $('#edit-shop'),
      del : $('#del-shop'),
      option : $('#add-invoice-form [name=shop-id]')
    }, ['owner_id', 'shop_id']);
  },
  invoices : function() {
    service.getInvoices({
      table : $('#invoices'),
      del : $('#del-invoice')
    }, ['invoice_id']);
  },
  updateAll : function() {
    views.items();
    views.shops();
    views.invoices();
  },
  clearInvoiceItems : function() {
    $('#added-items').html('');
  },
  clearModal : function($modal) {
    $modal = ($modal || $('.modal'));
    $modal.find('input,textarea').val('');
  },
  renderInvoiceDetails : function($target) {
    $target.html('');
    for(var i = 0; i < service._invoiceItems.length; i++) {
      var $panel = document.createElement('div');
      var $closeButton = document.createElement('button');
      var $panelHeading = document.createElement('div');
      var details = service._invoiceItems[i];

      $panel.className = 'panel panel-success';
      $panelHeading.className = 'panel-heading';
      $panelHeading.innerHTML = '<strong>' + details.name + ' | Quantity: </strong> ' +details.quantity + ' | <strong>Price:</strong>' + details.price;
      $closeButton.className = "btn btn-xs btn-danger pull-right";
      $closeButton.innerHTML = '&times; Remove';
      $panelHeading.appendChild($closeButton);
      $panel.appendChild($panelHeading);
      $target.append($panel);
    } 
  },
  renderTable : function(data, ignore, $targets, tableClasses) {
    tableClasses = tableClasses || 'table table-hover';
    if(!data || data.length === 0) { return "<h3 class='text-center'>:( Nothing to show.</h3>"; }

    ignore = ignore || [];
    var html = "<table class='"+ (tableClasses) + "'>";
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
};
