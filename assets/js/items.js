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
  views.items();

  // Add Forms 
  $('#add-item-form').on('submit', handlers.forms.addItem);

  // Delete Forms
  $('#del-item-form').on('submit', handlers.forms.deleteItem);
  
  // Edit Forms
  $('#edit-item-form').on('submit', handlers.forms.editItem);

  // Search Button
  $('#search-button').on('click', views.items);
  $('#refresh-button').on('click', function() {
    $('.keyword').val('');
    views.items();
  });
});

