// depends on views.js
var service = { 
  _items : [],
  _allItems : [],
  _shops : [],
  _invoiceItems : [],
  _detailedInvoices : {},
  _shopWiseInvoices : {},
  _profile : {},
  getAllItems : function($targets, keyword) {
    views.showLoader();
    $.ajax({
      url : 'php/get_all_items.php',
      dataType : 'json',
      data : { keyword : keyword },
      success : function(r) {
        views.hideLoader();
        if(!r.error) {
          service._allItems = r.data;
          $targets.table.html(views.renderTable(r.data, ['item_id', 'image'], { add : $targets.add }));
        }
      }
    }); 
  },
  editProfile : function(details, $msg) { 
    views.showLoader();
    $.ajax({
      url : 'php/update_profile.php',
      data : details,
      method : 'post',
      dataType : 'json',
      success : function(r) {
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.profile();
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      } 
    });
  },
  getProfile : function($targets) { 
    views.showLoader();
    $.ajax({
      url : 'php/get_profile.php',
      dataType : 'json',
      success : function(r) {
        views.hideLoader();
        if(r.data) {
          console.log(r.data);
          service._profile = r.data;
          r.data.phoneNumbers = (r.data.phoneNumbers && r.data.phoneNumbers.length > 0) ? r.data.phoneNumbers.join(',') : 'N/A';
          views.renderByTargets(r.data, $targets);
        } else {
          window.location = 'index.php';
        }
      } 
    });
  },
  addShop : function(details, $msg) {
    console.log(details);
    views.showLoader();
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
        views.clearMessage($msg);
        views.clearModal();
        views.hideLoader();
      }
    });
  },
  addFromItems : function(details, $msg) {
    console.log(details);
    views.showLoader();
    $.ajax({
      url : 'php/add_from_items.php',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.allItems();
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      }
    });
  },
  addItem : function(details, $msg) {
    console.log(details);
    views.showLoader();
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
        views.invoices();
        views.clearMessage($msg);
        views.clearModal();
        views.hideLoader();
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
    views.renderInvoiceDetails($target);
  },
  delInvoiceItem : function(item_id, $target) {
    for(var i = 0; i < service._invoiceItems.length; i++) {
      if(service._invoiceItems[i].item_id === item_id) {
        service._invoiceItems.splice(i, 1); 
      } 
    }
    views.renderInvoiceDetails($target);
  },
  addInvoice : function(details, $msg) {
    views.showLoader();
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
        service._invoiceItems = [];
        views.invoices();
        views.items();
        views.clearInvoiceItems();
        views.clearMessage($msg);
        views.clearModal();
        views.hideLoader();
      }
    });
  },
  getDetailedInvoiceDetails : function(detailedInvoiceId) {
    for(var i in service._detailedInvoices) {
      if(service._detailedInvoices[i].invoice_id === detailedInvoiceId) {
        return service._detailedInvoices[i];
      }
    }
    return null;
  },
  getItemDetails : function(itemId) {
    for(var i = 0; i < service._items.length; i++) {
      if(service._items[i].item_id === itemId) {
        return service._items[i];
      }
    }
    return null;
  },
  getFromAllItemDetails : function(itemId) {
    for(var i = 0; i < service._allItems.length; i++) {
      if(service._allItems[i].item_id === itemId) {
        return service._allItems[i];
      }
    }
    return null;
  },
  getShopDetails : function(shopId) {
    for(var i = 0; i < service._shops.length; i++) {
      if(service._shops[i].shop_id === shopId) {
        return service._shops[i];
      }
    }
    return null;
  },
  getProfileDetails : function() {
    return service._profile;
  },
  getShops : function($targets, ignore, keyword) {
    views.showLoader();
    $.ajax({
      url : 'php/get_shops.php',
      dataType : 'json',
      data: {keyword : keyword},
      success : function(r) {
        if(r.error) {
          $targets.html(r.msg);
        } else {
          service._shops = r.data;
          $targets.table.html(views.renderTable(r.data, ignore, {update : $targets.update, del : $targets.del}));
          for(var i = 0; i < r.data.length; i++) {
            $targets.option.append('<option value="' + r.data[i].shop_id + '">' + r.data[i].name + '</option>');
          }
        }
        views.hideLoader();
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your shops</h4></div>");
      }
    });
  },
  getItems : function($targets, ignore, keyword) {
    views.showLoader();
    $.ajax({
      url : 'php/get_items.php',
      data: {keyword : keyword},
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $targets.table.html(r.msg);
        } else {
          service._items = r.data;
          $targets.table.html(views.renderTable(r.data, ignore, {update: $targets.update, del : $targets.del}));
          $targets.option.html('');
          for(var i = 0; i < r.data.length; i++) {
            $targets.option.append('<option value="' + r.data[i].item_id + '">' + r.data[i].name + '</option>');
          }
          $targets.option.change();
        }
        views.hideLoader();
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your items</h4></div>");
      }
    });

  },
  getInvoices : function($targets, ignore, keyword) {
    views.showLoader();
    $.ajax({
      url : 'php/get_invoices.php',
      dataType : 'json',
      data : {keyword : keyword},
      success : function(r) {
        if(r.error) {
          $targets.table.html(r.msg);
        } else {
          $targets.table.html(views.renderTable(r.data, ignore , {update : $targets.update, del : $targets.del}));
        }
        views.hideLoader();
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your invoices</h4></div>");
      }
    });
  },
  getDetailedInvoices : function($targets, ignore, keyword) {
    views.showLoader();
    $.ajax({
      url : 'php/get_detailed_invoices.php',
      dataType : 'json',
      data : { keyword : keyword },
      success : function(r) {
        if(!r.error) {
          service._detailedInvoices = r.data;
          service._shopWiseInvoices = r.data.data;
          $targets.table.html(views.renderTable(r.data, ignore, $targets));
        } else {
          $targets.table.html(r.msg);
        }
        views.hideLoader();
      },
      error : function() {
        $targets.table.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your invoices</h4></div>");
      }
    });
  },
  delInvoice : function(details, $msg) {
    views.showLoader();
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
        views.items();
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      }
    }); 
  },
  delShop : function(details, $msg) {
    views.showLoader();
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
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      }
    }); 
  },
  delItem : function(details, $msg) {
    views.showLoader();
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
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      }
    }); 
  },
  editShop : function(details, $msg) {
    console.log(details);
    views.showLoader();
    $.ajax({
      url : 'php/update_shop.php',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.shops();
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      }
    });
  },
  editItem : function(details, $msg) {
    console.log(details);
    views.showLoader();
    $.ajax({
      url : 'php/update_item.php',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.items();
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      }
    });
  }
};
