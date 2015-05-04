// depends on [handlers.js, views.js, service.js]
// Bootstrapping
$(function() {
  $('.message').css('display', 'none');
  $('.message').html('');

  // Modals event handlers
  $('.add-modal').on('show.bs.modal', handlers.modals.addShow);
  $('.delete-modal').on('show.bs.modal', handlers.modals.deleteShow);
  $('.delete-modal').on('hide.bs.modal', handlers.modals.deleteHide);
  $('.edit-modal').on('show.bs.modal', handlers.modals.editShow);
  $('.edit-modal').on('hide.bs.modal', handlers.modals.editHide);

  // Retrieves all data and updates the views 
  views.shops();

  // Add Forms 
  $('#add-shop-form').on('submit', handlers.forms.addShop);
  // Delete Forms
  $('#del-shop-form').on('submit', handlers.forms.deleteShop);
  // Edit Forms
  $('#edit-shop-form').on('submit', handlers.forms.editShop);
  
  // Search Button
  $('#search-form').on('submit', function(e) { e.isDefaultPrevented = true; views.shops(); return false; })
  $('#refresh-button').on('click', function() {
    $('.keyword').val('');
    views.shops();
  });

});

