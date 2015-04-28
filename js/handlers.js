var handlers = {
  modals : {
    deleteShow : function(e) {
      window.scrollTo(0, e.relatedTarget.offsetHeight + 250);
      var id = e.relatedTarget.getAttribute('data-id');
      $(e.relatedTarget).parent().parent().addClass('delete-border');
      console.log($(e.currentTarget).find('.to-delete-id'));
      $(e.currentTarget).find('.to-delete-id').val(id);
    },
    deleteHide : function(e) {
      $('tr.delete-border').removeClass('delete-border');
    },
    editShow : function(e) {
      window.scrollTo(0, e.relatedTarget.offsetHeight + 250);
      var id = e.relatedTarget.getAttribute('data-id');
      $(e.relatedTarget).parent().parent().addClass('edit-border');
      $(e.currentTarget).find('.to-delete-id').val(id);
    },
    editHide : function(e) {
      $('tr.edit-border').removeClass('edit-border');
    },
  },
  forms : {
    addItem : function(e) {
      service.addItem({
        name : $('#add-item-form [name=name]').val(),
        description : $('#add-item-form [name=description]').val(),
        mrp : $('#add-item-form [name=mrp]').val(),
        sellprice : $('#add-item-form [name=sellprice]').val(),
        costprice : $('#add-item-form [name=costprice]').val(),
        quantity : $('#add-item-form [name=quantity]').val()
      }, $('#add-item-form .message'));
      return false;
    },
    addShop : function(e) {
      var $ele = $(e.currentTarget);
      service.addShop({
        name : $ele.find('[name=name]').val(),
        address : $ele.find('[name=address]').val(),
        state : $ele.find('[name=state]').val(),
        pincode : $ele.find('[name=pincode]').val()
      }, $ele.find('.message'));
      return false;
    },
    addInvoice : function(e) {
      service.addInvoice({
        shop_id : $(e.currentTarget).find('[name=shop-id] option:selected').val()
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
      $('#totalItemPrice').html('₹ ' + (item.sell_price * $('#item-to-add-quantity').val()));
    },
    priceChange : function(e) {
      $('#totalItemPrice').html('₹ ' + (e.currentTarget.value * $('#item-to-add-quantity').val()));
    },
    quantityChange : function(e) {
      $('#totalItemPrice').html('₹ ' + ($('#item-to-add-price').val() * e.currentTarget.value));
    }
  }
};
