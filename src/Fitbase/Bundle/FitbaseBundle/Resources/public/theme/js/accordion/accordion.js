(function () {

    var $container = $('.acc-container'),
        $trigger = $('.acc-trigger');

    $container.hide();

    var $blockActive = $trigger.first();
    var $blockOpened = $container.has('div.opened');

    if ($blockOpened.length) {
        $blockActive = $blockOpened.prev();
    }

    $blockActive.addClass('active').next().show();
    $container.scrollTo($blockActive);


    var fullWidth = $container.outerWidth(true);
    $trigger.css('width', fullWidth);
    $container.css('width', fullWidth);

    $trigger.on('click', function (e) {
        if ($(this).next().is(':hidden')) {
            $trigger.removeClass('active').next().slideUp(300);
            $(this).toggleClass('active').next().slideDown(300);
        }
        e.preventDefault();
    });

    // Resize
    $(window).on('resize', function () {
        fullWidth = $container.outerWidth(true)
        $trigger.css('width', $trigger.parent().width());
        $container.css('width', $container.parent().width());
    });

})();