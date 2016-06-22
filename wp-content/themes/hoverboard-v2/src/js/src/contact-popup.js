(function ($) {

  if (window.location.hash !== '#contact') {
    $('#contact').removeClass('active');
  } else {
    $('html').addClass('contact-popup-open');
  }

  $('a[href="#contact"]').addClass('contact-popup-btn');

  $('#contact-popup__close').on('click', function () {
    $('#contact').removeClass('active');
    $('html').removeClass('contact-popup-open');
    history.pushState('', document.title, window.location.pathname);
  });

  $('.linear-radio').each(function () {

    var $linearRadio = $(this);

    $linearRadio.find('input').each(function () {

      var
        $input = $(this);

      if ($input.is(':checked')) {
        $input.parent().parent().addClass('active');
      }
      // attach event handler
      $input.on('change', function () {

        var
          $inputChanged = $(this);

        // if CHANGING to checked
        if ( $inputChanged.is(':checked') ) {
          $linearRadio.find('input').parent().parent().removeClass('active');
          $inputChanged.parent().parent().addClass('active');
        }
      });


    });
  });

  $('.contact-popup-btn').on('click', function () {
    $('#contact').addClass('active');
    $('html').addClass('contact-popup-open');
  });

}(jQuery));
