(function ($) {

    function Tree(element) {
        this.init(element);
    }

    $.extend(Tree.prototype, {

        element: undefined,

        init: function (element) {
            this.element = element;
        },

        colorize: function (percent) {
            // Get container with tree fields
            var container = this.element.find('.fields');
            // without this construction
            // break something in other scripts
            (function (self, percent, elements) {

                elements.each(function (key, element) {

                    // change color for other
                    var container = $(element);
                    container.css('fill', self.color(percent));
                });

            })(this, percent, container.find('path'));
        },

        color: function (percent) {

            var random = Math.floor((Math.random() * 80) + 1);

            if ((random < (100 - percent))) {

                var grey = new Array('#A0A0A0', '#B0B0B0', '#C0C0C0',
                    '#E0E0E0', '#D0D0D0', '#F0F0F0');

                return grey[Math.floor((Math.random() * grey.length))];
            }

            var green = new Array('#007400', '#005000', '#006c00',
                '#24d000', '#00b400', '#00b400',
                '#00b400', '#00b400', '#00b400',
                '#00b400', '#00b400', '#003000',
                '#006000', '#003000', '#005800',
                '#005800', '#005800', '#005800');

            return green[Math.floor((Math.random() * green.length))];
        }
    });


    $.fn.tree = function (percent) {
        var colorizedTree = new Tree($(this));
        colorizedTree.colorize(parseInt(percent));
        return colorizedTree;
    };

    var container = $(document);
    container.bind('percentHealthUser', function (event) {
        var container = $('svg[id=tree]');
        container.tree(event.percent)
    });

})(jQuery);