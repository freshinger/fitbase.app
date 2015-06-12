(function () {
    $.extend($, {
        controller: function (selector, callback) {
            var container = $(selector);
            if (container.length) {
                callback(container);
            }
        }
    });
})(jQuery);