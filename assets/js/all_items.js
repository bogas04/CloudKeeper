$(function() {
  views.items();
  views.allItems();
  $('#add-from-items-form').on('submit', handlers.forms.addFromItems);
  $('#add-from-items').on('show.bs.modal', handlers.modals.addFromItems);

  // Search Button
  $('#search-form').on('submit', function(e) { e.isDefaultPrevented = true; views.allItems(); return false; })
  $('#refresh-button').on('click', function() {
    $('.keyword').val('');
    views.allItems();
  });
});
