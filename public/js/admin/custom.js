jQuery(function ($) {
    $(document).delegate(".dropdown-menu [data-keepOpenOnClick]", "click", function (e) {
        e.stopPropagation();
    });

    $(".flotChartCtrl").each(function () {
        var $ctrl = $(this);
        var $plot = $(this).find(".plotChart");

        $(this).find("li").each(function () {
            $(this).on("click", function () {
                var options = eval("[" + $plot.attr("ui-options") + "]");
                var newData = eval($(this).attr("plot-data"));

                if (newData == null) newData = [[0, 0]];

                $ctrl.find("li").each(function () {
                    $(this).removeClass("active");
                });
                $(this).addClass("active");

                var plotObj = $plot.data("plot");
                var plotData = plotObj.getData();

                plotData[0].data = newData;

                plotObj.setData(plotData);
                plotObj.setupGrid();
                plotObj.draw();
            })
        });
    });

    $('[data-tooltip]').tooltip();
});
