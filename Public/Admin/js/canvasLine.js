$(function () {
    //lineÍ¼±í
    var randomScalingFactor = function () {
        return Math.round(Math.random() * 100);
        //return 0;
    };
    var randomColorFactor = function () {
        return Math.round(Math.random() * 255);
    };
    var randomColor = function (opacity) {
        return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
    };

    var config = {
        type: 'line',
        data: {
            labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
            datasets: [{
                label: "My First dataset",
                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
                fill: false,
                borderDash: [5, 5]
            }, {
                hidden: true,
                label: 'hidden dataset',
                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
            }, {
                label: "My Second dataset",
                data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Chart.js Line Chart'
            },
            tooltips: {
                mode: 'label',
                callbacks: {
                    // beforeTitle: function() {
                    //     return '...beforeTitle';
                    // },
                    // afterTitle: function() {
                    //     return '...afterTitle';
                    // },
                    // beforeBody: function() {
                    //     return '...beforeBody';
                    // },
                    // afterBody: function() {
                    //     return '...afterBody';
                    // },
                    // beforeFooter: function() {
                    //     return '...beforeFooter';
                    // },
                    // footer: function() {
                    //     return 'Footer';
                    // },
                    // afterFooter: function() {
                    //     return '...afterFooter';
                    // },
                }
            },
            hover: {
                mode: 'dataset'
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        show: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        show: true,
                        labelString: 'Value'
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }]
            }
        }
    };

    $.each(config.data.datasets, function (i, dataset) {
        dataset.borderColor = randomColor(0.4);
        dataset.backgroundColor = randomColor(0.5);
        dataset.pointBorderColor = randomColor(0.7);
        dataset.pointBackgroundColor = randomColor(0.5);
        dataset.pointBorderWidth = 1;
    });
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);

});