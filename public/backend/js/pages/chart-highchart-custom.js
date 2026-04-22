"use strict";
$(document).ready(function () {
    setTimeout(function () {
        $(function () {
            const categories = window.chartData.children.map(
                (item) => item.type
            );
            const clicksData = window.chartData.children.map((item) =>
                Number(item.clicks)
            );
            const orderClicksData = window.orderChartData.children.map((item) =>
                Number(
                    window.orderChartData.children.find(
                        (o) => o.type === item.type
                    )?.clicks || 0
                )
            );

            Highcharts.chart("click-counts", {
                chart: {
                    type: "column",
                },
                // colors: ['#19BCBF', '#7759de', '#FF9764', '#2DCEE3'],
                title: {
                    text: "Click Counts",
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: "Product Type",
                    },
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "Total Clicks",
                    },
                },
                tooltip: {
                    shared: true,
                    headerFormat:
                        '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat:
                        '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: "</table>",
                    useHTML: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.009,
                        borderWidth: 0,
                    },
                },
                series: [
                    {
                        name: "Product Clicks",
                        data: clicksData,
                        color: "#3498db",
                    },
                    {
                        name: "Order Clicks",
                        data: orderClicksData,
                        color: "#e74c3c",
                    },
                ],
                legend: {
                    enabled: true,
                },
            });
        });
    }, 700);
});
