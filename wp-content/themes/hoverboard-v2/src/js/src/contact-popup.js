(function ($) {

  if (window.location.hash === '#contact') {
    $('html').addClass('contact-popup-open');
    $('#contact').addClass('active');
  }

  $('a[href="#contact"]').addClass('contact-popup-btn');

  $('#contact-popup__close').on('click', function (e) {
    $('html').removeClass('contact-popup-open');
    $('#contact').removeClass('active');
    history.pushState('', document.title, window.location.pathname);

    e.preventDefault();
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
    $('html').addClass('contact-popup-open');
    $('#contact').addClass('active');
  });

}(jQuery));
