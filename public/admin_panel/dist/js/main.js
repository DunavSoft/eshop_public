function readFile(input) {
  const files = input.files;

  if (files && files[0]) {
    var fileReader = new FileReader();

    fileReader.addEventListener("load", function(e) {
      $('#current_image0').attr('src', e.target.result);
      $('#image0').val(e.target.result);
    });

    fileReader.readAsDataURL(files[0]);

    return true;
  }
}

function attachCustomEventsHandlers () {
  $('body').on('image:read', function (event, params) {
    readFile(params.input, params.id);
  });
}

$(function () {
  attachCustomEventsHandlers();
});
