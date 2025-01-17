<div class="form-group row">
  <label for="<?= $shopsettingsFileElement[1] . $language->uri ?>" class="col-sm-2 col-form-label"><?php echo $shopsettingsFileElement[2]; ?></label>


  <div class="col-sm-10">
    <?php
    
    $data['id'] = $shopsettingsFileElement[1] . $language->uri;
    $data['name'] = "save[$language->uri][$shopsettingsFileElement[1]]";
    $data['value'] = $shopsettings[$shopsettingsFileElement[1] . $language->uri] ?? '';
    $data['class'] = 'form-control';
    $data['placeholder'] = $shopsettingsFileElement[2];

    if ($shopsettingsFileElement[0] == 'input') {

      echo form_input($data);
    } elseif ($shopsettingsFileElement[0] == 'textarea') {

      echo form_textarea($data);
    } elseif ($shopsettingsFileElement[0] == 'textarea_edit') {

      $data['value'] = $shopsettings[$shopsettingsFileElement[1] . $language->uri] ?? '';
      $data['class'] .= ' ckeditor';
      echo form_textarea($data);
    } elseif ($shopsettingsFileElement[0] == 'dropdown') {
      echo form_dropdown($shopsettingsFileElement[1], $shopsettingsFileElement[3], set_value($shopsettingsFileElement[1], $active = 1), 'class="form-control"');
    }
    ?>
    <small class="form-text text-muted" title="<?= $shopsettingsFileElement[2] ?>">{<?= $shopsettingsFileElement[1] ?>}</small>
  </div>
</div>
