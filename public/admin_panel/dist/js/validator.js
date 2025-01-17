const settings = {
  submit: false,
  errorClass: 'error',
  errorElement: 'span',
  onkeyup: false,
  ignore: '.skipvalidation, :hidden :visible',
  focusInvalid: true,
  invalidHandler: function (event, validator) {
    const $firstInvalidField = $(validator.errorList[0].element);
    const $panelElement = $firstInvalidField.closest('.panel');

    if ($panelElement.length > 0) {
      // Discover accordion element
      $panelElement.find('.panel-collapse').collapse('show');

      const $languageTabElement = $firstInvalidField.closest('.tab-pane');

      // Discover language tab element
      if ($languageTabElement) {
        $('#' + $languageTabElement.attr('aria-labelledby')).tab('show')

        $firstInvalidField.focus();
      }
    }

    $firstInvalidField.focus();
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
