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
