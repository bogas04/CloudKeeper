function renderTable(data, ignore) {
  if(!data || data.length === 0) { return "<h3 class='text-center'>:( Nothing to show.</h3>"; }
  ignore = ignore || [];
  var html = "<table class='table table-bordered table-striped table-hover'>";
  var headers = "<thead> <tr>";
  var rows = "";

  for(var i in data[0]) {
    if(ignore.indexOf(i) < 0) {
      headers += ("<th>" + i.toUpperCase() + "</th>");
    } 
  } 
  html += (headers + '</tr></thead>');

  for(i = 0; i < data.length; i++) {
    rows += '<tr>';
    for(j in data[i]) {
      if(ignore.indexOf(j) < 0) {
        rows += ('<td>' + data[i][j] + '</td>');
      } 
    }
    rows += '</tr>';
  }
  html += rows;

  return html;
}
var service = { 
  addShop : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  addItem : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  addInvoice : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  getShops : function($target, ignore) {
    $.ajax({
      url : 'php/get_shops.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $target.html(r.msg);
        } else {
          $target.html(renderTable(r.data, ignore));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your shops</h4></div>");
      }
    });
  },
  getItems : function($target, ignore) {
    $.ajax({
      url : 'php/get_items.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $target.html(r.msg);
        } else {
          $target.html(renderTable(r.data, ignore));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your items</h4></div>");
      }
    });

  },
  getInvoices : function($target, ignore) {
    $.ajax({
      url : 'php/get_invoices.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $target.html(r.msg);
        } else {
          $target.html(renderTable(r.data, ignore));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your invoices</h4></div>");
      }
    });

  },
  getAnalytics : function($target) {

  }
};
$(function() {
  // Bootstrapping
  $('.message').css('display', 'none');
  $('.message').html('');
  service.getItems($('#items'), ['owner_id', 'item_id', 'image']);
  service.getShops($('#shops'), ['owner_id', 'shop_id']);
  service.getInvoices($('#invoices'));

  $('#add-item-form').on('submit', function() {
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
  $('#add-shop-form').on('submit', function() {
    service.addShop({
      name : $('#add-shop-form [name=name]').val(),
      address : $('#add-shop-form [name=address]').val(),
      state : $('#add-shop-form [name=state]').val(),
      country : $('#add-shop-form [name=country]').val(),
      pincode : $('#add-shop-form [name=pincode]').val()
    }, $('#add-shop-form .message'));
    return false;
  });  
  $('#add-invoice-form').on('submit', function() {
    service.addInvoice({
      username : $('#add-invoice-form [name=username]').val(),
      bla : $('#add-invoice-form [name=bla]').val(),
      bla : $('#add-invoice-form [name=bla]').val(),
      bla : $('#add-invoice-form [name=bla]').val(),
      bla : $('#add-invoice-form [name=bla]').val(),
      bla : $('#add-invoice-form [name=bla]').val(),
    }, $('#add-invoice-form .message'));
    return false;
  });  
});
