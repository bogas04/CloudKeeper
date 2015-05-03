// depends on service.js
var views = {
  showLoader : function() {
    $('.loading-bar').css('visibility', 'visible');
  },
  hideLoader : function() {
    // Server too fast, can't see the beautiful loading bar, added a delay
    setTimeout(function() { $('.loading-bar').css('visibility', 'hidden'); }, 1250);
  },
  profile : function() {
    service.getProfile({
      firstName : $('#profile-info .first-name'),
      lastName : $('#profile-info .last-name'),
      username : $('#profile-info .username'),
      phoneNumbers : $('#profile-info .phones')
    });
  },
  allItems : function() {
    service.getAllItems({
      table : $('#all-items'),
      add : $('#add-from-items')
    });
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
  detailedInvoices : function() {
    service.getDetailedInvoices({
      table : $('#invoices'),
      del : $('#del-invoice'),
      more : $('#detailed-invoice')
    }, ['invoice_id', 'items']);
  },
  updateAll : function() {
    views.items();
    views.shops();
    views.detailedInvoices();
    //views.invoices();
  },
  clearMessage : function($msg) {
    $msg = ($msg || $('.message'));
    setTimeout(function() {
      $msg.html('');
      $msg.hide('slow',function() { $msg.css('display', 'none'); });
    }, 1000);
  },
  clearInvoiceItems : function() {
    $('#added-items').html('');
  },
  clearModal : function($modal) {
    $modal = ($modal || $('.modal'));
    $modal.find('input,textarea').val('');
  },
  closeModal : function($modal) {
    setTimeout(function() { 
      $modal = ($modal || $('.modal'));
      $modal.find('input,textarea').val('');
      $modal.modal('hide');
    }, 1000);
  },
  renderByTargets : function(data, $targets) {
    for(var i in $targets) {
      if($targets[i].is('textarea,input,select')) {
        $targets[i].val(data[i]); 
      } else {
        $targets[i].html(data[i]); 
      } 
    }
  },
  renderInvoiceDetails : function($target) {
    $target.html('');
    for(var i = 0; i < service._invoiceItems.length; i++) {
      var $panel = document.createElement('div');
      var $closeButton = document.createElement('a');
      var $panelHeading = document.createElement('div');
      var details = service._invoiceItems[i];

      $panel.className = 'panel panel-success';
      $panelHeading.className = 'panel-heading';
      $panelHeading.innerHTML = '<strong>' + details.name + ' | Quantity: </strong> ' +details.quantity + ' | <strong>Price:</strong>' + details.price;
      $closeButton.className = "btn btn-xs btn-danger pull-right";
      $closeButton.setAttribute('data-id', details.item_id);
      $closeButton.innerHTML = '&times; Remove';
      $closeButton.onclick = handlers.invoiceDetails.deleteItem;
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

    var keys = Object.keys(data);
    for(var i in data[keys[0]]) {
      if(ignore.indexOf(i) < 0) {
        headers += ("<th>" + i.toUpperCase() + "</th>");
      } 
    } 
    if($targets) {
      html += (headers + '<th>Operations</th></tr></thead><tbody>');
    } else {
      html += (headers + '</tr></thead><tbody>');
    }

    for(i = 0; i < keys.length; i++) {
      rows += '<tr>';
      for(j in data[keys[i]]) {
        if(ignore.indexOf(j) < 0) {
          rows += ('<td>' + data[keys[i]][j] + '</td>');
        } 
      }
      if($targets) {
        rows += '<td>';
        // TODO: need to fix this somehow
        if($targets.update) {
          rows += '<button class="btn btn-xs btn-info" data-id="' + (data[keys[i]].item_id | data[keys[i]].shop_id | data[keys[i]].invoice_id) + '" data-toggle="modal" data-target="#' + $targets.update.attr('id') + '">Edit</button>';
        }
        if($targets.del) {
          rows += '<button class="btn btn-xs btn-danger" data-id="' + (data[keys[i]].item_id | data[keys[i]].shop_id | data[keys[i]].invoice_id) + '" data-toggle="modal" data-target="#' + $targets.del.attr('id') + '">Delete</button>';
        } 
        if($targets.more) {
          rows += '<button class="btn btn-xs btn-default" data-id="' + (data[keys[i]].item_id | data[keys[i]].shop_id | data[keys[i]].invoice_id) + '" data-toggle="modal" data-target="#' + $targets.more.attr('id') + '">More</button>';
        }
        if($targets.add) {
          rows += '<button class="btn btn-xs btn-success" data-id="' + (data[keys[i]].item_id | data[keys[i]].shop_id | data[keys[i]].invoice_id) + '" data-toggle="modal" data-target="#' + $targets.add.attr('id') + '">Add</button>';
        }
        rows += '</td>';
      }
    }
    html += rows + ('</tr></tbody></table>');

    return html;
  }
};
