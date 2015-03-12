(function ($) {

    function Waterfall(container, data, config) {
        this.init(container, data, config);
    }

    $.extend(Waterfall.prototype, {

        /**
         * Initial function,
         * improve config, define sizes and other
         *
         * @param container
         * @param data
         * @param options
         */
        init: function (container, data, options) {

            var config = $.extend({
                width: container.get(0).clientWidth,
                height: container.get(0).clientWidth * 0.8,
                center: container.get(0).clientWidth / 2
            }, options);


            var svg = d3.select(container.selector)
                .select('svg')
                .attr('width', config.width)
                .attr('height', config.height);

            var waterfall = svg.append('g').attr('class', 'waterfall');

            this.__drawWaterfallBackground(waterfall, data, config);
            this.__drawWaterfallBackgroundLabels(waterfall, data, config);

        },

        /**
         * Draw background columns
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawWaterfallBackground: function (container, data, config) {
            var waterfallBackground = container.append('g')
                .attr('class', 'waterfall-column');

            var count = 0;

            var waterfallBackgroundElements = waterfallBackground.selectAll('.waterfall-column')
                .data(data)
                .enter()
                .append('g')
                .attr('class', 'waterfall-column-element');

            waterfallBackgroundElements.append('rect')
                .attr('x', function (d) {
                    var distance = (((config.width * config.width_background / 100 ) ) * count);
                    count = count + 1;
                    return config.center + distance;
                }).attr('y', config.height)
                .attr('width', function () {
                    return config.width * config.width_background / 100
                })
                .attr('height', 0)
                .attr('fill', function (d) {
                    return d.color;
                })
                .transition()
                .duration(config.duration)
                .attr('y', function (d) {
                    return config.height - (d.value * config.height / 100);
                })
                .attr('height', function (d) {
                    return d.value * config.height / 100;
                });

            var count = 0;
            waterfallBackgroundElements
                .append('g')
                .attr('class', 'waterfall-column-text')
                .append('text')
                .attr('y', config.height)
                .attr('x', function (d) {
                    var distance = (((config.width * config.width_background / 100 ) ) * count);
                    count = count + 1;
                    return config.center + (distance + (config.width * config.width_background / 100) / 4);
                })
                .text(function (d) {
                    return '0%';
                })
                .transition()
                .duration(config.duration)
                .attr('y', function (d) {
                    return config.height - (d.value * config.height / 100) - 5;
                })
                .tween('text', function (d) {
                    // get current value as starting point for tween animation
                    // create interpolator and do not show nasty floating numbers
                    var interpolator = d3.interpolateRound(0, d.value);
                    // this returned function will be called a couple
                    // of times to animate anything you want inside
                    // of your custom tween
                    return function (t) {
                        // set new value to current text element
                        this.textContent = interpolator(t) + '%';
                    };
                });
            ;

        },

        /**
         * Draw labels for columns
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawWaterfallBackgroundLabels: function (container, data, config) {
            var waterfallColumnLabel = container.append('g')
                .attr('class', 'waterfall-column-label');

            var index = 0;
            var counter = 0;
            var waterfallColumnLabelElements = waterfallColumnLabel
                .selectAll('.waterfall-column-label').data(data)
                .enter()
                .append('g').attr('class', 'waterfall-column-label-element')
                .each(function (d) {
                    counter++;
                })
                .attr('transform', function (d) {
                    index = index + 1;
                    return 'translate(' + 20 + ',' + (config.height - (index * 25)) + ')';
                });

            waterfallColumnLabelElements.append("rect")
                .attr('fill', function (d) {
                    return d.color;
                })
                .attr('x', '0').attr('y', '0')
                .attr('width', '0').attr('height', '0')
                .transition()
                .duration(config.duration)
                .attr('x', '-10').attr('y', '-15')
                .attr('width', '18').attr('height', '18');


            (function (self) {

                waterfallColumnLabelElements.append("text")
                    .attr('x', '0')
                    .text(function (d) {
                        return d.label;
                    })
                    .style('font-size', '0em')

                    .transition()
                    .duration(config.duration)
                    .style('font-size', '1em')
                    .attr('x', '20')
                    .each('end', function (d) {
                        counter--;
                        if (counter == 0) {
                            self.__drawWaterfallBackgroundTitle(
                                waterfallColumnLabel, data, config);
                        }
                    });

            })(this);

        },

        /**
         * Draw a title for all labels after all events
         * and animations
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawWaterfallBackgroundTitle: function (container, data, config) {

            var waterfallColumnLabelText = container.append('g')
                .attr('class', 'waterfall-column-label-text')
                .attr('transform', function (d) {
                    var index = (data.length + 3);
                    return 'translate(' + 5 + ',' + (config.height - (index * 25)) + ')';
                });

            waterfallColumnLabelText
                .append('foreignObject')
                .attr('x', 5)
                .attr('y', 5)
                .attr('width', config.width / 2)
                .attr('height', config.height / 5)
                .append('xhtml:body')
                .style('font-size', '0.9em')
                .html(config.title);
        }

    });


    $.fn.waterfall = function (data, config) {

        return new Waterfall($(this), data, $.extend({
            delay: 500,
            duration: 1500,
            width_background: 20
        }, config));
    }


})(jQuery);