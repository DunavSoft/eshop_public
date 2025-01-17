<div class="form-group row">
  <label for="<?= $settingsFileElement[1] . $language->uri ?>" class="col-sm-2 col-form-label"><?php echo $settingsFileElement[2]; ?></label>

  <div class="col-sm-10">
    <?php

    $data['id'] = $settingsFileElement[1] . $language->uri;
    $data['name'] = "save[$language->uri][$settingsFileElement[1]]";
    $data['value'] = $settings[$settingsFileElement[1] . $language->uri] ?? '';
    $data['class'] = 'form-control';
    $data['placeholder'] = $settingsFileElement[2];

    if ($settingsFileElement[0] == 'input') {

      echo form_input($data);
    } elseif ($settingsFileElement[0] == 'textarea') {

      echo form_textarea($data);
    } elseif ($settingsFileElement[0] == 'textarea_edit') {

      $data['value'] = $settings[$settingsFileElement[1] . $language->uri] ?? '';
      $data['class'] .= ' ckeditor';
      echo form_textarea($data);
    } elseif ($settingsFileElement[0] == 'dropdown') {
      echo form_dropdown($settingsFileElement[1], $settingsFileElement[3], set_value($settingsFileElement[1], $active = 1), 'class="form-control"');
    }
    ?>
    <small class="form-text text-muted" title="<?= $settingsFileElement[2] ?>">{<?= $settingsFileElement[1] ?>}</small>
  </div>
</div>
