$(function() {
  views.items();
  views.allItems();
  $('#add-from-items-form').on('submit', handlers.forms.addFromItems);
  $('#add-from-items').on('show.bs.modal', handlers.modals.addFromItems);
});
