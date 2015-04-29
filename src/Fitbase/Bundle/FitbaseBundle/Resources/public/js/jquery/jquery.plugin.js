(function ($) {

    /**
     * Method to check is plugin
     * has been loaded
     *
     * @param name
     */
    $.plugin = function (name) {
        return (typeof($.fn[name]) == 'function');
    }

})(jQuery);