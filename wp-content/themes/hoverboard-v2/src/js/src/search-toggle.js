(function ($) {

  var
    $toggleSearch = $('.toggle-search'),
    $searchForm = $('#form--search');

  // moved this to an inline <script> to avoid flash of it being rendered
  // $searchForm.addClass('inactive');

  $toggleSearch
    .attr('data-search-showing', 'true')
    .on('click', function () {

      $toggleSearch.toggleClass('active');
      $searchForm.toggleClass('inactive');

      if ( !$('#form--search').hasClass('inactive') ) {
        $searchForm.find('.form--search-input').focus();
      }

    });

}(jQuery));
