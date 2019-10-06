
$('.star .top svg').on('mouseenter', function () {
  let $p = $('.star .top svg path');
  let num = $(this).data('num');
  let text = ['非常不满意', '还行', '挺好', '满意', '非常满意'];

  $.each($p, function (i, ele) {
    if (i / 4 < num)
      $(ele).css({ fill: 'rgb(255, 247, 0)' });
    else
      $(ele).css({ fill: '#ccc' });
  });

  $('.star .b').text(text[num - 1]);
  $('.nr form').data('star', num);
});

$('.nr form .btn').on('click', function () {
  let data = {};
  data.star = $('.nr form').data('star');
  data.pl = $('.nr form textarea').prop('value');
  data.id = $('.ddxxid').data('id');

  $.post('http://store.com/index/center/pl', {
    data: JSON.stringify(data)
  }, function () {
    window.close();
  });
});




















































