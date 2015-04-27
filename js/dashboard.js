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
var service = { 
  _items : [],
  _shops : [],
  _invoiceItems : [],
  addShop : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop.php',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.shops();
      }
    });
  },
  addItem : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_item.php',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.items();
      }
    });
  },
  addInvoiceItem : function(details, $target) {
    if(!details 
        || !details.item_id 
        || !details.quantity 
        || !details.price 
        || !details.name 
        || details.quantity < 1) {
      alert("Invalid details");
      return;
    }
    for(var i = 0; i < service._invoiceItems.length; i++) {
      if(service._invoiceItems[i].item_id === details.item_id) {
        alert("You have already added this item to invoice");
        return;
      }
    }
    for(var i = 0; i < service._items.length; i++) {
      if(service._items[i].item_id === details.item_id && (parseFloat(service._items[i].quantity) < parseFloat(details.quantity))) {
        console.log(service._items[i], details);
        alert("You don't have enough of " + details.name + " to sell. You have : " + service._items[i].quantity + " you are selling : " + details.quantity);
        return;
      } 
    }
    service._invoiceItems.push(details);
    service.renderInvoiceDetails($target);
  },
  renderInvoiceDetails : function($target) {
    $target.html('');
    for(var i = 0; i < service._invoiceItems.length; i++) {
      var $panel = document.createElement('div');
      var $closeButton = document.createElement('button');
      var $panelHeading = document.createElement('div');
      var $panelBody = document.createElement('div');
      var details = service._invoiceItems[i];

      $panel.className = 'panel panel-info';
      $panelHeading.className = 'panel-heading';
      $panelHeading.innerHTML = details.name;
      $closeButton.className = "btn btn-xs btn-danger pull-right";
      $closeButton.innerHTML = '&times; Remove';
      $panelHeading.appendChild($closeButton);
      $panelBody.className = 'panel-body';
      $panelBody.innerHTML =  'Quantity:' +details.quantity + ', Price: ' + details.price;
      $panel.appendChild($panelHeading);
      $panel.appendChild($panelBody);
      $target.append($panel);
    } 
  },
  addInvoice : function(details, $msg) {
    details.items = service._invoiceItems;
    console.log(details);
    $.ajax({
      url : 'php/add_invoice.php',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.invoices();
      }
    });
  },
  getItemDetails : function(itemId) {
    for(var i = 0; i < service._items.length; i++) {
      if(service._items[i].item_id === itemId) {
        return service._items[i];
      }
    }
  },
  getShops : function($targets, ignore) {
    $.ajax({
      url : 'php/get_shops.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $targets.html(r.msg);
        } else {
          service._shops = r.data;
          $targets.table.html(renderTable(r.data, ignore, {update : $targets.update, del : $targets.del}));
          for(var i = 0; i < r.data.length; i++) {
            $targets.option.append('<option value="' + r.data[i].shop_id + '">' + r.data[i].name + '</option>');
          }
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your shops</h4></div>");
      }
    });
  },
  getItems : function($targets, ignore) {
    $.ajax({
      url : 'php/get_items.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $targets.table.html(r.msg);
        } else {
          service._items = r.data;
          $targets.table.html(renderTable(r.data, ignore, {update: $targets.update, del : $targets.del}));
          for(var i = 0; i < r.data.length; i++) {
            console.log(r.data[i]);
            $targets.option.append('<option value="' + r.data[i].item_id + '">' + r.data[i].name + '</option>');
          }
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your items</h4></div>");
      }
    });

  },
  getInvoices : function($targets, ignore) {
    $.ajax({
      url : 'php/get_invoices.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $targets.table.html(r.msg);
        } else {
          $targets.table.html(renderTable(r.data, ignore , {update : $targets.update, del : $targets.del}));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your invoices</h4></div>");
      }
    });
  },
  getAnalytics : function($target) {

  },
  delInvoice : function(details, $msg) {
    $.ajax({
      url: 'php/delete_invoice.php',
      data: details,
      dataType: 'json',
      type: 'post',
      success: function(r) {
        console.log(r);
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.invoices();
      }
    }); 
  },
  delShop : function(details, $msg) {
    $.ajax({
      url: 'php/delete_shop.php',
      data: details,
      dataType: 'json',
      type: 'post',
      success: function(r) {
        console.log(r);
        console.log($msg);
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.shops();
      }
    }); 
  },
  delItem : function(details, $msg) {
    $.ajax({
      url: 'php/delete_item.php',
      data: details,
      dataType: 'json',
      type: 'post',
      success: function(r) {
        console.log(r);
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.items();
      }
    }); 
  }
};
var views = {
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
  }
};
$(function() {
  // Bootstrapping
  $('.message').css('display', 'none');
  $('.message').html('');
  
  views.updateAll();

  // Add Item
  $('#add-item-form').on('submit', function(e) {
    service.addItem({
      name : $('#add-item-form [name=name]').val(),
      description : $('#add-item-form [name=description]').val(),
      mrp : $('#add-item-form [name=mrp]').val(),
      sellprice : $('#add-item-form [name=sellprice]').val(),
      costprice : $('#add-item-form [name=costprice]').val(),
      quantity : $('#add-item-form [name=quantity]').val()
    }, $('#add-item-form .message'));
    return false;
  });  

  // Add Shop
  $('#add-shop-form').on('submit', function(e) {
    service.addShop({
      name : $('#add-shop-form [name=name]').val(),
      address : $('#add-shop-form [name=address]').val(),
      state : $('#add-shop-form [name=state]').val(),
      pincode : $('#add-shop-form [name=pincode]').val()
    }, $('#add-shop-form .message'));
    return false;
  });  

  // Add Invoice
  $('#add-invoice-form').on('submit', function(e) {
    service.addInvoice({
      shop_id : $('#add-invoice-form [name=shop-id] option:selected').val()
    }, $('#add-invoice-form .message'));
    return false;
  });

  // Add Invoice Item
  $('#add-this-item').on('click', function(e) {
    service.addInvoiceItem({
      item_id : $('#item-to-add-id option:selected').val(),
      name : $('#item-to-add-id option:selected').text(),
      quantity : $('#item-to-add-quantity').val(),
      price : $('#item-to-add-price').val()
    }, $('#added-items'));
  });

  // TODO: Use e instead of re-calling the selector
  // Delete Forms
  $('#del-invoice-form').on('submit', function(e) {
    console.log($(e.currentTarget));
    service.delInvoice({
      invoice_id : $(e.currentTarget).find('[name=invoice_id]').val()
    }, $(e.currentTarget).find('.message'));
    e.isDefaultPrevented = true;
    return false;
  });
  // Delete Forms
  $('#del-item-form').on('submit', function(e) {
    console.log($(e.currentTarget));
    service.delItem({
      item_id : $(e.currentTarget).find('[name=item_id]').val()
    }, $(e.currentTarget).find('.message'));
    return false;
  });
  // Delete Forms
  $('#del-shop-form').on('submit', function(e) {
    console.log($(e.currentTarget));
    service.delShop({
      shop_id : $(e.currentTarget).find('[name=shop_id]').val()
    }, $(e.currentTarget).find('.message'));
    return false;
  });

  // Event Handlers :
  $('#item-to-add-id').on('focus', function(e) {
    var item = service.getItemDetails($(e.currentTarget).find('option:selected').val());
    $('#item-to-add-quantity').val(1);
    $('#item-to-add-price').val(item.sell_price);
    $('#totalItemPrice').html('₹ ' + (item.sell_price * $('#item-to-add-quantity').val()));
  });
  $('#item-to-add-quantity').on('keyup', function(e) {
    console.log($('#item-to-add-price').val() * $('#item-to-add-quantity').val());
    $('#totalItemPrice').html('₹ ' + ($('#item-to-add-price').val() * $('#item-to-add-quantity').val()));
  });
  $('#item-to-add-price').on('keyup', function(e) {
    console.log($('#item-to-add-price').val() * $('#item-to-add-quantity').val());
    $('#totalItemPrice').html('₹ ' + ($('#item-to-add-price').val() * $('#item-to-add-quantity').val()));
  });

  // Modals event handlers
  $('.delete-modal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    console.log(id);
    $(e.relatedTarget).parent().parent().addClass('delete-border');
    console.log($(e.currentTarget).find('.to-delete-id'));
    $(e.currentTarget).find('.to-delete-id').val(id);
  });
  $('.edit-modal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    $(e.relatedTarget).parent().parent().addClass('edit-border');
    $(e.currentTarget).find('.to-delete-id').val(id);
  });
  //TODO
  $('.edit-modal').on('hide.bs.modal', function(e) {
    $('tr.edit-border').removeClass('.edit-border');
  });

});
