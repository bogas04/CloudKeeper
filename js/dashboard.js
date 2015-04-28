// depends on [handlers.js, views.js, service.js]
// Bootstrapping
$(function() {
  $('.message').css('display', 'none');
  $('.message').html('');

  // Invoice Details
  $('#item-to-add-id').on('change keydown', handlers.invoiceDetails.init);
  $('#item-to-add').on('click', handlers.invoiceDetails.addItem);
  $('#item-to-add-quantity').on('keyup', handlers.invoiceDetails.quantityChange);
  $('#item-to-add-price').on('keyup', handlers.invoiceDetails.priceChange);

  // Modals event handlers
  $('.add-modal').on('show.bs.modal', handlers.modals.addShow);
  $('.delete-modal').on('show.bs.modal', handlers.modals.deleteShow);
  $('.delete-modal').on('hide.bs.modal', handlers.modals.deleteHide);
  $('.edit-modal').on('show.bs.modal', handlers.modals.editShow);
  $('.edit-modal').on('hide.bs.modal', handlers.modals.editHide);

  // Retrieves all data and updates the views 
  views.updateAll();

  // Add Item
  $('#add-item-form').on('submit', handlers.forms.addItem);  
  $('#add-shop-form').on('submit', handlers.forms.addShop);  
  $('#add-invoice-form').on('submit', handlers.forms.addInvoice);

  // Delete Forms
  $('#del-invoice-form').on('submit', handlers.forms.deleteInvoice);
  $('#del-item-form').on('submit', handlers.forms.deleteItem);
  $('#del-shop-form').on('submit', handlers.forms.deleteShop);
});
