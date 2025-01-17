const settings = {
  submit: false,
  errorClass: 'is-invalid',
  onkeyup: false,
  ignore: '.skipvalidation, :hidden :visible',
  focusInvalid: true,
  success: function(label, element) {
    $(element).addClass('is-valid');

    label.remove();
  },
  onfocusout: function (element) {
    if (!this.checkable(element)) {
      this.element(element);
    }
  }
};

(function () {
  $('form:not(.suppress)').each(function () {
      $(this).validate(settings);
  });
})();
