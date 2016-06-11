(function ($) {

  $('html')
    .removeClass('no-js')
    .addClass('js');

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
