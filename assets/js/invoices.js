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
  $('#detailed-invoice').on('show.bs.modal', handlers.modals.detailedInvoiceShow);
  $('.delete-modal').on('hide.bs.modal', handlers.modals.deleteHide);

  views.detailedInvoices();
  // Add Forms 
  $('#add-invoice-form').on('submit', handlers.forms.addInvoice);

  // Delete Forms
  $('#del-invoice-form').on('submit', handlers.forms.deleteInvoice);
});

