$(document).ready(function(){
    $('[data-bs-toggle="popover"]').popover();
  });

  $(window).on('load', function () {
    $('[data-bs-toggle="popover"]').popover();
  });

  $(document).on('loaded.bs.popover', '[data-bs-toggle="popover"]', function () {
    $(this).popover();
  });

  $(document).on('click', '[data-bs-toggle="popover"]', function () {
    $(this).popover('show');
  });

  
  