(function () {
    'use strict';

    angular.module('app')
        .controller('DashboardCtrl', ['$scope', DashboardCtrl])

    function DashboardCtrl($scope) {

        $scope.line2 = {};
        $scope.radar1 = {};

        $scope.line2.options = {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['Email','Affiliate','Video Ads','Direct','Search']
            },
            toolbox: {
                show : false,
                feature : {
                    restore : {show: true, title: "restore"},
                    saveAsImage : {show: true, title: "save as image"}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : ['Mon.','Tue.','Wed.','Thu.','Fri.','Sat.','Sun.']
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'Email',
                    type:'line',
                    stack: 'Sum',
                    data:[120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name:'Affiliate',
                    type:'line',
                    stack: 'Sum',
                    data:[220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name:'Video Ads',
                    type:'line',
                    stack: 'Sum',
                    data:[150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name:'Direct',
                    type:'line',
                    stack: 'Sum',
                    data:[320, 332, 301, 334, 390, 330, 320]
                },
                {
                    name:'Search',
                    type:'line',
                    stack: 'Sum',
                    data:[820, 932, 901, 934, 1290, 1330, 1320]
                }
            ]
        };

        $scope.radar1.options = {
            animation: false,
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                orient : 'vertical',
                x : 'right',
                y : 'bottom',
                data:['Allocated Budget','Actual Spending']
            },
            toolbox: {
                show : false,
                feature : {
                    restore : {show: true, title: "restore"},
                    saveAsImage : {show: true, title: "save as image"}
                }
            },
            polar : [
               {
                   indicator : [
                       { text: 'sales', max: 6000},
                       { text: 'dministration', max: 16000},
                       { text: 'Information Techology', max: 30000},
                       { text: 'Customer Support', max: 38000},
                       { text: 'Development', max: 52000},
                       { text: 'Marketing', max: 25000}
                    ]
                }
            ],
            calculable : true,
            series : [
                {
                    name: 'Budget vs spending',
                    type: 'radar',
                    data : [
                        {
                            value : [4300, 10000, 28000, 35000, 50000, 19000],
                            name : 'Allocated Budget'
                        },
                         {
                            value : [5000, 14000, 28000, 31000, 42000, 21000],
                            name : 'Actual Spending'
                        }
                    ]
                }
            ]
        };

    }


})(); 