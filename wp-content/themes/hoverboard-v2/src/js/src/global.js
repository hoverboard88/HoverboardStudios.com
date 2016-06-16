(function ($) {

  $('html')
    .removeClass('no-js')
    .addClass('js');

  // for testing
  $('#contact').removeClass('active');

  $('#contact-popup__close').on('click', function () {
    $('#contact').removeClass('active');
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

  $('#contact-popup-btn').on('click', function (e) {
    $('#contact').addClass('active');
    e.preventDefault();
  });

  var
    $toggleSearch = $('#toggle-search'),
    $searchForm = $('#form--search');

  $searchForm.addClass('inactive');

  $toggleSearch
    .attr('data-search-showing', 'true')
    .on('click', function () {

      $toggleSearch.toggleClass('active');
      $searchForm.toggleClass('inactive');

    });

}(jQuery));
