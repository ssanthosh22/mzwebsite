$(window).on('load resize', function () {
  if ($(this).width() < 640) {
    $('table tfoot').hide();
  } else {
    $('table tfoot').show();
  }  
});

// See:
// http://www.sitepoint.com/responsive-data-tables-comprehensive-list-solutions
