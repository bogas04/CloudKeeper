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
