(function () {
    $.controller = function (selector, callback) {
        var container = $(selector);
        if (container.length) {
            container.each(function (key, element) {
                callback($(element));
            });

        }
    }
})(jQuery);