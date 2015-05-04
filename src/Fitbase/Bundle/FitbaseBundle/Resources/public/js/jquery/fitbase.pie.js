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

            var config = $.extend({
                width: container.get(0).clientWidth,
                height: container.get(0).clientWidth * 0.5
            }, options);


            var radius = Math.min(config.width, config.height) * 0.35;

            $.extend(config, {
                radius: radius,
                radius_inner: radius * 0.55
            });

            var svg = d3.select(container.selector)
                .select('svg')
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

            var position_x = config.width * 0.75;
            var position_y = config.height * 0.5;

            var pie = container.append('g')
                .attr('class', 'pieChart--diagramm')
                .attr('filter', 'url(#pieChartInsetShadow)')
                .attr('transform', 'translate(' + position_x + ',' + position_y + ')');

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
                .attr('r', config.radius_inner);

            centerContainer.append('circle')
                .attr('id', 'pieChart-clippy')
                .attr('class', 'pieChart--center--innerCircle')
                .attr('r', 0)
                .transition()
                .duration(config.duration)
                .delay(config.delay)
                .attr('r', config.radius_inner - (config.height * 0.02))
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

            var position_x = config.width * 0.1;
            var position_y = config.height * 0.1;

            var pieLabels = container.append('g')
                .attr('class', 'pieChart--labels')
                .attr('transform', 'translate(' + position_x + ',' + position_y + ')');

            var elements = pieLabels
                .selectAll(".pieChart--labels")
                .data(data)
                .enter()
                .append("g")
                .attr('transform', function (d) {
                    return 'translate(0,' + (d.index * (config.height * 0.08)) + ')';
                });

            elements.append("rect")
                .attr('fill', function (d) {
                    return d.color;
                })
                .attr('x', '0')
                .attr('y', '0')
                .attr('width', '0')
                .attr('height', '0')
                .transition()
                .duration(config.duration)
                .attr('x', -(config.width * 0.03))
                .attr('y', -(config.width * 0.02))
                .attr('width', config.width * 0.03)
                .attr('height', config.width * 0.03);

            elements.append("text")
                .attr('x', '0')
                .text(function (d) {
                    return d.label;
                })
                .transition()
                .duration(config.duration)
                .attr('x', (config.width * 0.01));
        }
    });


    $.fn.pie = function (data, config) {

        return new Pie($(this), data, $.extend({
            duration: 1500,
            delay: 500
            //radius_inner: 50
        }, config));
    };

})(jQuery);
