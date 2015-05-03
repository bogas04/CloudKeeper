// depends on [handlers.js, views.js, service.js]
// Bootstrapping
$(function() {
  $('.message').css('display', 'none');
  $('.message').html('');
  views.profile();
  $('#edit-profile').on('show.bs.modal', handlers.modals.editShow);
  $('#edit-profile-form').on('submit', handlers.forms.editProfile);
});
