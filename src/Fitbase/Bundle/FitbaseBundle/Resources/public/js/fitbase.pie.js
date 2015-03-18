(function ($) {

    function Pie(element, data, config) {
        this.init(element, data, config);
    }

    $.extend(Pie.prototype, {
        width: undefined,
        height: undefined,
        radius: undefined,
        container: undefined,

        init: function (container, data, options) {


            var parent = container.closest('div');

            var config = $.extend({
                width: parent.get(0).clientWidth,
                height: parent.get(0).clientWidth * 0.65
            }, options);


            $.extend(config, {
                radius: Math.min(config.width, config.height) / 3.2
            });
            console.info(config);

            var svg = d3.select(container.selector)
                .attr('width', config.width)
                .attr('height', config.height);

            this.__renderPie(svg, data, config);
            this.__renderLabels(svg, data, config);
        },

        /**
         * Render pie chart
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __renderPie: function (container, data, config) {

            var pie = container.append('g')
                .attr('class', 'pieChart--diagramm')
                .attr('filter', 'url(#pieChartInsetShadow)')
                .attr('transform', 'translate(' + config.width / 1.4 + ',' + config.height / 2 + ')');

            var pieData = d3.layout.pie()
                .value(function (d) {
                    return d.value;
                });

            var arc = d3.svg.arc()
                .outerRadius(config.radius * 0.9)
                .innerRadius(0);

            var pieChartPieces = pie.datum(data)
                .selectAll('path').data(pieData)
                .enter()
                .append('path')
                .style("fill", function (d) {
                    return d.data.color;
                })
                .attr('d', arc)
                .each(function () {
                    this._current = {
                        startAngle: 0,
                        endAngle: 0
                    };
                })
                .transition()
                .duration(config.duration)
                .attrTween('d', function (d) {
                    var interpolate = d3.interpolate(this._current, d);
                    this._current = interpolate(0);

                    return function (t) {
                        return arc(interpolate(t));
                    };
                });

            var centerContainer = pie.append('g')
                .attr('class', 'pieChart--center');

            centerContainer.append('circle')
                .attr('class', 'pieChart--center--outerCircle')
                .attr('r', 0)
                .attr('filter', 'url(#pieChartDropShadow)')
                .transition()
                .duration(config.duration)
                .delay(config.delay)
                .attr('r', config.radius - (config.radius_inner * 100 / config.radius));


            centerContainer.append('circle')
                .attr('id', 'pieChart-clippy')
                .attr('class', 'pieChart--center--innerCircle')
                .attr('r', 0)
                .transition()
                .duration(config.duration)
                .delay(config.delay)
                .attr('r', config.radius - ((config.radius_inner + 5) * 100 / config.radius))
                .attr('fill', '#fff');
        },

        /**
         * Render labels
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __renderLabels: function (container, data, config) {

            var pieLabels = container.append('g').attr('class', 'pieChart--labels')
                .attr('transform', 'translate(0,' + ((config.height / 2) - config.radius) + ')');

            var elements = pieLabels
                .selectAll(".pieChart--labels")
                .data(data)
                .enter()
                .append("g")
                .attr('transform', function (d) {
                    return 'translate(' + 10 + ',' + (d.index * 25) + ')';
                });

            elements.append("rect")
                .attr('fill', function (d) {
                    return d.color;
                })
                .attr('x', '0').attr('y', '0')
                .attr('width', '0').attr('height', '0')
                .transition()
                .duration(config.duration)
                .attr('x', '-10').attr('y', '-15')
                .attr('width', '18').attr('height', '18');

            elements.append("text")
                .attr('x', '0')
                .text(function (d) {
                    return d.label;
                })
                .transition()
                .duration(config.duration)
                .attr('x', '20');
        }
    });


    $.fn.pie = function (data, config) {

        return new Pie($(this), data, $.extend({
            duration: 1500,
            delay: 500,
            radius_inner: 50
        }, config));
    };

})(jQuery);