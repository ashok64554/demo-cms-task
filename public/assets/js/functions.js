$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
  });
});

$(function(){
    $('input[type=color]').change(function(){
       $(this).addClass('changed');
    })
})

