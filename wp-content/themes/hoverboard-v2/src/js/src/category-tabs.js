(function ($) {

  var
    $categoryTabs = $('#category-tabs');

  $categoryTabs.find('a').each(function () {

    // if the pathname in url is contained in the href
    if ( $(this).attr('href').indexOf(document.location.pathname) > -1 ) {
      $categoryTabs.find('li').removeClass('active');
      $(this).parent().addClass('active');
    }

  });

}(jQuery));
