'use strict';
$(document).ready(function() {
    setTimeout(function() {
        // [ XY-Stacked-1 chart ] start
        $(function() {
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("am-xy-1", am4charts.XYChart);

            let data = window.chartData.children

            chart.data = data;

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "type";
            categoryAxis.title.text = "Product Type";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 20;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.title.text = "Total Clicks";

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = "clicks";
            series.dataFields.categoryX = "type";
            series.name = "Clicks";
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            series.stacked = true;

            chart.cursor = new am4charts.XYCursor();
        });
    }, 700);
});
