(function ($) {

    function Barometer(container, data, config) {
        this.init(container, data, config);
    }

    $.extend(Barometer.prototype, {
        width: undefined,
        height: undefined,
        init: function (container, data, options) {

            var config = $.extend({
                width: container.get(0).clientWidth,
                height: container.get(0).clientWidth * 0.8,
                center: container.get(0).clientWidth / 8
            }, options);


            var svg = d3.select(container.selector)
                .select('svg')
                .attr('width', config.width)
                .attr('height', config.height);

            var barometer = svg.append('g').attr('class', 'barometer');

            this.__drawBarometerScala(barometer, data, config);
            this.__drawBarometerLines(barometer, data, config);
            this.__drawBarometerText(barometer, data, config);
            this.__drawBarometerPosition(barometer, data, config);

        },
        /**
         * Draw a barometer scala with red, green and yellow
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerScala: function (container, data, config) {
            var barometerScala = container.append('g')
                .attr('class', 'barometer-scala')
                .attr('filter', 'url(#pieChartInsetShadow)');

            barometerScala.selectAll('.barometer-scala')
                .data(config.scala)
                .enter()
                .append("rect")
                .attr('x', config.center - (config.scala_weight / 2))
                .attr('y', config.height)
                .attr('rx', function (d) {
                    if (d.round) {
                        return "10px";
                    }
                    return '0px';
                })
                .attr('ry', function (d) {
                    if (d.round) {
                        return "20px";
                    }
                    return '0px';
                })
                .attr('width', config.scala_weight)
                .attr('height', 0)
                .attr('fill', function (d) {
                    return d.color;
                })
                .transition()
                .duration(config.duration)
                .attr('y', function (d) {
                    return (d.start * config.height / 100);
                })
                .attr('height', function (d) {
                    return (d.height * config.height / 100);
                })
            ;
        },
        /**
         * Draw a barometer lines
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerLines: function (container, data, config) {
            var barometerLine = container.append('g')
                .attr('class', 'barometer-lines')
                .attr('filter', 'url(#pieChartDropShadow)');

            barometerLine.append('line')
                .attr('x1', config.center)
                .attr('x2', config.center)
                .style('stroke', '#000000')
                .attr('y1', config.height)
                .attr('y2', config.height)
                .transition()
                .duration(config.duration)
                .attr('y1', 0)
                .attr('y2', (config.height * 0.97))
            ;

            barometerLine.selectAll('.barometer-lines')
                .data(Array.apply(null, Array(parseInt(config.lines))).map(function (_, i) {
                    return i;
                }))
                .enter()
                .append('line')
                .attr('x1', config.center - 5)
                .attr('x2', config.center + 5)
                .attr('y1', config.height)
                .attr('y2', config.height)
                .style('stroke', '#000000')
                .transition()
                .duration(config.duration)
                .attr('y1', function (d) {
                    return ((d * 100 / parseInt(config.lines)) * (config.height * 0.95)) / 100;
                })
                .attr('y2', function (d) {
                    return ((d * 100 / parseInt(config.lines)) * (config.height * 0.95)) / 100;
                })
            ;
        },
        /**
         * Draw a current barometer position
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerPosition: function (container, data, config) {
            var barometerPosition = container.append('g')
                .attr('class', 'barometer-position');

            barometerPosition.append('polygon')
                .attr('points', function () {
                    var position = (config.height * 0.97);

                    var top = [config.center - 20, position + 5];
                    var bottom = [config.center - 20, position - 5];
                    var right = [config.center, (config.height * 0.97)];
                    return top + ' ' + bottom + ' ' + right;
                })
                .style('fill', '#000000')
                .transition()
                .delay(config.delay)
                .duration(config.duration)
                .attr('points', function () {

                    var position = ((config.height * 0.97) - (data.value * (config.height * 0.97)) / 100);

                    var top = [config.center - 20, position + 5];
                    var bottom = [config.center - 20, position - 5];
                    var right = [config.center, ((config.height * 0.97) - (data.value * (config.height * 0.97)) / 100)];
                    return top + ' ' + bottom + ' ' + right;
                });

        },
        /**
         * Draw a barometer text (description)
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerText: function (container, data, config) {
            var barometerText = container.append('g')
                .attr('class', 'barometer-text');

            barometerText.data(data.value)
                .append('foreignObject')
                .attr('x', config.width / 4)
                .attr('y', 0)
                .attr('width', config.width / 1.4)
                .attr('height', config.height)
                .append('xhtml:body')
                .style('font-size', '0.9em')
                .html(data.description);
        }
    });


    $.fn.barometer = function (data, config) {

        return new Barometer($(this), data, $.extend({
            delay: 500,
            duration: 1500,
            lines: 30,
            scala: [
                {
                    start: 60,
                    height: 40,
                    color: 'red',
                    round: true
                },
                {
                    start: 60,
                    height: 20,
                    color: 'red'
                },
                {
                    start: 30,
                    height: 30,
                    color: 'yellow'
                },
                {
                    start: 0,
                    height: 30,
                    color: '#a2d049'
                }
            ],
            scala_weight: 20
        }, config));
    };

})(jQuery);