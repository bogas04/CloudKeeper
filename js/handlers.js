// depends on service.js
var handlers = {
  modals : {
    addShow : function(e) {
      var id = e.currentTarget.getAttribute('id');
      if(id === 'add-invoice') {
        if(service._items.length === 0) {
          $('#'+id).modal('hide');
          alert("You need to have some items before making an invoice");
          e.isDefaultPrevented = true;
          return false;
        }
        if(service._shops.length === 0) {
          $('#'+id).modal('hide');
          alert("You need to have a shop before making an invoice");
          e.isDefaultPrevented = true;
          return false;
        }
      }
    },
    deleteShow : function(e) {
      var id = e.relatedTarget.getAttribute('data-id');
      $(e.relatedTarget).parent().parent().addClass('delete-border');
      console.log($(e.currentTarget).find('.to-delete-id'));
      $(e.currentTarget).find('.to-delete-id').val(id);
    },
    deleteHide : function(e) {
      $('tr.delete-border').removeClass('delete-border');
    },
    editShow : function(e) {
      var $ele = $(e.currentTarget);
      var id = e.relatedTarget.getAttribute('data-id');
      $(e.relatedTarget).parent().parent().addClass('edit-border');
      $ele.find('.to-edit-id').val(id);
      switch(e.currentTarget.getAttribute('data-type')) {
        case 'shop' :
          views.renderShopEdit(service.getShopDetails(id), {
            name : $ele.find('[name=name]'),
            state : $ele.find('[name=state]'),
            pin_code : $ele.find('[name=pin_code]'),
            address : $ele.find('[name=address]')
          });
          break;
        case 'item' :
          views.renderItemEdit(service.getItemDetails(id), {
            name : $ele.find('[name=name]'),
            description : $ele.find('[name=description]'),
            cost_price : $ele.find('[name=cost_price]'),
            sell_price : $ele.find('[name=sell_price]'),
            mrp : $ele.find('[name=mrp]'),
            quantity : $ele.find('[name=quantity]')
          });
          break;
      }
    },
    editHide : function(e) {
      $('tr.edit-border').removeClass('edit-border');
    },
    detailedInvoiceShow : function(e) {
      var id = e.relatedTarget.getAttribute('data-id');
      var $ele = $(e.currentTarget);
      var data = service.getDetailedInvoiceDetails(id);
      $ele.find('.detailed-invoice').html(views.renderTable([data], ['invoice_id', 'items']));
      $ele.find('.detailed-items').html(views.renderTable(data.items, ['item_id']));
    },
    addFromItems : function(e) {
      var id = e.relatedTarget.getAttribute('data-id');
      if(service.getItemDetails(id) !== null) {
        alert("You already own this item");
        e.isDefaultPrevented = true;
        return false;
      }
      var $ele = $(e.currentTarget);
      $ele.find('.to-add-id').val(id);
      views.renderItemEdit(service.getFromAllItemDetails(id), {
        name : $ele.find('[name=name]'),
        description : $ele.find('[name=description]'),
        mrp : $ele.find('[name=mrp]')
      });
    }
  },
  forms : {
    addItem : function(e) {
      var $ele = $(e.currentTarget);
      service.addItem({
        name : $ele.find('[name=name]').val(),
        description : $ele.find('[name=description]').val(),
        mrp : $ele.find('[name=mrp]').val(),
        sell_price : $ele.find('[name=sell_price]').val(),
        cost_price : $ele.find('[name=cost_price]').val(),
        quantity : $ele.find('[name=quantity]').val()
      }, $ele.find('.message'));
      return false;
    },
    addFromItems : function(e) {
      var $ele = $(e.currentTarget);
      service.addItem({
        item_id : $ele.find('[name=item_id]').val(),
        sell_price : $ele.find('[name=sell_price]').val(),
        cost_price : $ele.find('[name=cost_price]').val(),
        quantity : $ele.find('[name=quantity]').val()
      }, $ele.find('.message'));
      return false;
    },
    addShop : function(e) {
      var $ele = $(e.currentTarget);
      service.addShop({
        name : $ele.find('[name=name]').val(),
        address : $ele.find('[name=address]').val(),
        state : $ele.find('[name=state]').val(),
        pin_code : $ele.find('[name=pin_code]').val()
      }, $ele.find('.message'));
      return false;
    },
    addInvoice : function(e) {
      service.addInvoice({
        shop_id : $(e.currentTarget).find('[name=shop-id] option:selected').val(),
        items : service._invoiceItems
      }, $(e.currentTarget).find('.message'));
      return false;
    },
    deleteInvoice : function(e) {
      service.delInvoice({
        invoice_id : $(e.currentTarget).find('[name=invoice_id]').val()
      }, $(e.currentTarget).find('.message'));
      e.isDefaultPrevented = true;
      return false;
    },
    deleteItem : function(e) {
      service.delItem({
        item_id : $(e.currentTarget).find('[name=item_id]').val()
      }, $(e.currentTarget).find('.message'));
      e.isDefaultPrevented = true;
      return false;
    },
    deleteShop : function(e) {
      service.delShop({
        shop_id : $(e.currentTarget).find('[name=shop_id]').val()
      }, $(e.currentTarget).find('.message'));
      e.isDefaultPrevented = true;
      return false;
    },
    editShop : function(e) {
      var $ele = $(e.currentTarget);
      service.editShop({
        shop_id : $ele.find('[name=shop_id]').val(),
        name : $ele.find('[name=name]').val(),
        address : $ele.find('[name=address]').val(),
        state : $ele.find('[name=state]').val(),
        pin_code : $ele.find('[name=pin_code]').val()
      }, $ele.find('.message'));
      e.isDefaultPrevented = true;
      return false;
    },
    editItem : function(e) {
      var $ele = $(e.currentTarget);
      service.editItem({
        item_id : $ele.find('[name=item_id]').val(),
        cost_price : $ele.find('[name=cost_price]').val(),
        sell_price : $ele.find('[name=sell_price]').val(),
        quantity : $ele.find('[name=quantity]').val()
      }, $ele.find('.message'));
      e.isDefaultPrevented = true;
      return false;
    }
  },
  invoiceDetails : {
    addItem : function(e) {
      service.addInvoiceItem({
        item_id : $('#item-to-add-id option:selected').val(),
        name : $('#item-to-add-id option:selected').text(),
        quantity : $('#item-to-add-quantity').val(),
        price : $('#item-to-add-price').val()
      }, $('#added-items'));
    },
    init : function(e) {
      var item = service.getItemDetails($(e.currentTarget).find('option:selected').val());
      $('#item-to-add-quantity').val(1);
      $('#item-to-add-price').val(item.sell_price);
      $('#total-item-price').html((item.sell_price * $('#item-to-add-quantity').val()));
    },
    priceChange : function(e) {
      $('#total-item-price').html((e.currentTarget.value * $('#item-to-add-quantity').val()));
    },
    quantityChange : function(e) {
      $('#total-item-price').html(($('#item-to-add-price').val() * e.currentTarget.value));
    }
  }
};
