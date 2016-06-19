$(document).ready( function () {

      var imgTime = 4000,
            tranSpeed = 400;


      var listItems = $ ('[id="slider"]').children('li'),
           dotItems = $ ('#dots').children('li'),
            listLen = listItems.length,
            current,
            changeTimeout;


      function moveTo(newIndex) {
            var i = newIndex;
            if (newIndex == 'prev') {
                i = (current > 0) ? (current - 1) : (listLen - 1);
            }
            if (newIndex == 'next') {
              i = (current < listLen - 1) ? (current + 1) : 0;
            }
            dotItems.removeClass('active')
                    .eq(i).addClass('active');
            listItems.fadeOut(tranSpeed)
                   .eq(i).fadeIn(tranSpeed);
            current = i;
            clearTimeout(changeTimeout);
            changeTimeout = setTimeout(function() { moveTo('next'); }, imgTime);
      };

$("#dots li").click(function () {
      var i = $('#dots li').index(this);
      moveTo(i);
});
$("#prev").click(function () {
   moveTo('prev');
});
$("#next").click(function () {
      moveTo('next');
});
     moveTo('next');
});
