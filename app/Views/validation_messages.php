<script>
  const VALIDATIONS_MESSAGES_V = {
    required: '<?= lang('Validation.formsErrorRequired'); ?>',
    email: '<?= lang('Validation.formsErrorInvalidEmail'); ?>',
    maxlength: '<?= lang('Validation.formsErrorMaxLength'); ?>',
    minlength: '<?= lang('Validation.formsErrorMinLength'); ?>',
    extension: '<?= lang('Validation.formsErrorExtension'); ?>',
    filesize: '<?= lang('Validation.formsErrorFilesize'); ?>',
    number: '<?= lang('Validation.formsErrorInvalidNumber'); ?>',
    iban: '<?= lang('Validation.formsErrorInvalidIban'); ?>'
  };

  <?php if ($locale != 'en'):?>
    $.extend($.validator.messages, VALIDATIONS_MESSAGES_V);
  <?php endif; ?>
</script>
