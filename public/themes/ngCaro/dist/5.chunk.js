webpackJsonp([5,10],{

/***/ 654:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ng2_charts_ng2_charts__ = __webpack_require__(356);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ng2_charts_ng2_charts___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_ng2_charts_ng2_charts__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__chartjs_component__ = __webpack_require__(662);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__chartjs_routing_module__ = __webpack_require__(685);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ChartJSModule", function() { return ChartJSModule; });
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var ChartJSModule = (function () {
    function ChartJSModule() {
    }
    return ChartJSModule;
}());
ChartJSModule = __decorate([
    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
        imports: [
            __WEBPACK_IMPORTED_MODULE_3__chartjs_routing_module__["a" /* ChartJSRoutingModule */],
            __WEBPACK_IMPORTED_MODULE_1_ng2_charts_ng2_charts__["ChartsModule"]
        ],
        declarations: [__WEBPACK_IMPORTED_MODULE_2__chartjs_component__["a" /* ChartJSComponent */]]
    })
], ChartJSModule);

//# sourceMappingURL=/Users/jacky/Documents/workspaces/Caro-Framework/public/themes/ngCaro/src/chartjs.module.js.map

/***/ }),

/***/ 662:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(0);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ChartJSComponent; });
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};

var ChartJSComponent = (function () {
    function ChartJSComponent() {
        // lineChart
        this.lineChartData = [
            { data: [65, 59, 80, 81, 56, 55, 40], label: 'Series A' },
            { data: [28, 48, 40, 19, 86, 27, 90], label: 'Series B' },
            { data: [18, 48, 77, 9, 100, 27, 40], label: 'Series C' }
        ];
        this.lineChartLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
        this.lineChartOptions = {
            animation: false,
            responsive: true
        };
        this.lineChartColours = [
            {
                backgroundColor: 'rgba(148,159,177,0.2)',
                borderColor: 'rgba(148,159,177,1)',
                pointBackgroundColor: 'rgba(148,159,177,1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(148,159,177,0.8)'
            },
            {
                backgroundColor: 'rgba(77,83,96,0.2)',
                borderColor: 'rgba(77,83,96,1)',
                pointBackgroundColor: 'rgba(77,83,96,1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(77,83,96,1)'
            },
            {
                backgroundColor: 'rgba(148,159,177,0.2)',
                borderColor: 'rgba(148,159,177,1)',
                pointBackgroundColor: 'rgba(148,159,177,1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(148,159,177,0.8)'
            }
        ];
        this.lineChartLegend = true;
        this.lineChartType = 'line';
        // barChart
        this.barChartOptions = {
            scaleShowVerticalLines: false,
            responsive: true
        };
        this.barChartLabels = ['2006', '2007', '2008', '2009', '2010', '2011', '2012'];
        this.barChartType = 'bar';
        this.barChartLegend = true;
        this.barChartData = [
            { data: [65, 59, 80, 81, 56, 55, 40], label: 'Series A' },
            { data: [28, 48, 40, 19, 86, 27, 90], label: 'Series B' }
        ];
        // Doughnut
        this.doughnutChartLabels = ['Download Sales', 'In-Store Sales', 'Mail-Order Sales'];
        this.doughnutChartData = [350, 450, 100];
        this.doughnutChartType = 'doughnut';
        // Radar
        this.radarChartLabels = ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'];
        this.radarChartData = [
            { data: [65, 59, 90, 81, 56, 55, 40], label: 'Series A' },
            { data: [28, 48, 40, 19, 96, 27, 100], label: 'Series B' }
        ];
        this.radarChartType = 'radar';
        // Pie
        this.pieChartLabels = ['Download Sales', 'In-Store Sales', 'Mail Sales'];
        this.pieChartData = [300, 500, 100];
        this.pieChartType = 'pie';
        // PolarArea
        this.polarAreaChartLabels = ['Download Sales', 'In-Store Sales', 'Mail Sales', 'Telesales', 'Corporate Sales'];
        this.polarAreaChartData = [300, 500, 100, 40, 120];
        this.polarAreaLegend = true;
        this.polarAreaChartType = 'polarArea';
    }
    // events
    ChartJSComponent.prototype.chartClicked = function (e) {
        console.log(e);
    };
    ChartJSComponent.prototype.chartHovered = function (e) {
        console.log(e);
    };
    return ChartJSComponent;
}());
ChartJSComponent = __decorate([
    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
        template: __webpack_require__(698)
    }),
    __metadata("design:paramtypes", [])
], ChartJSComponent);

//# sourceMappingURL=/Users/jacky/Documents/workspaces/Caro-Framework/public/themes/ngCaro/src/chartjs.component.js.map

/***/ }),

/***/ 685:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__(214);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__chartjs_component__ = __webpack_require__(662);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ChartJSRoutingModule; });
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var routes = [
    {
        path: '',
        component: __WEBPACK_IMPORTED_MODULE_2__chartjs_component__["a" /* ChartJSComponent */],
        data: {
            title: 'Charts'
        }
    }
];
var ChartJSRoutingModule = (function () {
    function ChartJSRoutingModule() {
    }
    return ChartJSRoutingModule;
}());
ChartJSRoutingModule = __decorate([
    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
        imports: [__WEBPACK_IMPORTED_MODULE_1__angular_router__["a" /* RouterModule */].forChild(routes)],
        exports: [__WEBPACK_IMPORTED_MODULE_1__angular_router__["a" /* RouterModule */]]
    })
], ChartJSRoutingModule);

//# sourceMappingURL=/Users/jacky/Documents/workspaces/Caro-Framework/public/themes/ngCaro/src/chartjs-routing.module.js.map

/***/ }),

/***/ 698:
/***/ (function(module, exports) {

module.exports = "<div class=\"animated fadeIn\">\n    <div class=\"card-columns cols-2\">\n        <div class=\"card\">\n            <div class=\"card-header\">\n                Line Chart\n                <div class=\"card-actions\">\n                    <a href=\"http://www.chartjs.org\">\n                        <small class=\"text-muted\">docs</small>\n                    </a>\n                </div>\n            </div>\n            <div class=\"card-block\">\n                <div class=\"chart-wrapper\">\n                    <canvas baseChart class=\"chart\" [datasets]=\"lineChartData\" [labels]=\"lineChartLabels\" [options]=\"lineChartOptions\" [colors]=\"lineChartColours\" [legend]=\"lineChartLegend\" [chartType]=\"lineChartType\" (chartHover)=\"chartHovered($event)\" (chartClick)=\"chartClicked($event)\"></canvas>\n                </div>\n            </div>\n        </div>\n        <div class=\"card\">\n            <div class=\"card-header\">\n                Bar Chart\n                <div class=\"card-actions\">\n                    <a href=\"http://www.chartjs.org\">\n                        <small class=\"text-muted\">docs</small>\n                    </a>\n                </div>\n            </div>\n            <div class=\"card-block\">\n                <div class=\"chart-wrapper\">\n                    <canvas baseChart class=\"chart\" [datasets]=\"barChartData\" [labels]=\"barChartLabels\" [options]=\"barChartOptions\" [legend]=\"barChartLegend\" [chartType]=\"barChartType\" (chartHover)=\"chartHovered($event)\" (chartClick)=\"chartClicked($event)\"></canvas>\n                </div>\n            </div>\n        </div>\n        <div class=\"card\">\n            <div class=\"card-header\">\n                Doughnut Chart\n                <div class=\"card-actions\">\n                    <a href=\"http://www.chartjs.org\">\n                        <small class=\"text-muted\">docs</small>\n                    </a>\n                </div>\n            </div>\n            <div class=\"card-block\">\n                <div class=\"chart-wrapper\">\n                    <canvas baseChart class=\"chart\" [data]=\"doughnutChartData\" [labels]=\"doughnutChartLabels\" [chartType]=\"doughnutChartType\" (chartHover)=\"chartHovered($event)\" (chartClick)=\"chartClicked($event)\"></canvas>\n                </div>\n            </div>\n        </div>\n        <div class=\"card\">\n            <div class=\"card-header\">\n                Radar Chart\n                <div class=\"card-actions\">\n                    <a href=\"http://www.chartjs.org\">\n                        <small class=\"text-muted\">docs</small>\n                    </a>\n                </div>\n            </div>\n            <div class=\"card-block\">\n                <div class=\"chart-wrapper\">\n                    <canvas baseChart class=\"chart\" [datasets]=\"radarChartData\" [labels]=\"radarChartLabels\" [chartType]=\"radarChartType\" (chartHover)=\"chartHovered($event)\" (chartClick)=\"chartClicked($event)\"></canvas>\n                </div>\n            </div>\n        </div>\n        <div class=\"card\">\n            <div class=\"card-header\">\n                Pie Chart\n                <div class=\"card-actions\">\n                    <a href=\"http://www.chartjs.org\">\n                        <small class=\"text-muted\">docs</small>\n                    </a>\n                </div>\n            </div>\n            <div class=\"card-block\">\n                <div class=\"chart-wrapper\">\n                    <canvas baseChart class=\"chart\" [data]=\"pieChartData\" [labels]=\"pieChartLabels\" [chartType]=\"pieChartType\" (chartHover)=\"chartHovered($event)\" (chartClick)=\"chartClicked($event)\"></canvas>\n                </div>\n            </div>\n        </div>\n        <div class=\"card\">\n            <div class=\"card-header\">\n                Polar Area Chart\n                <div class=\"card-actions\">\n                    <a href=\"http://www.chartjs.org\">\n                        <small class=\"text-muted\">docs</small>\n                    </a>\n                </div>\n            </div>\n            <div class=\"card-block\">\n                <div class=\"chart-wrapper\">\n                    <canvas baseChart class=\"chart\" [data]=\"polarAreaChartData\" [labels]=\"polarAreaChartLabels\" [legend]=\"polarAreaLegend\" [chartType]=\"polarAreaChartType\" (chartHover)=\"chartHovered($event)\" (chartClick)=\"chartClicked($event)\"></canvas>\n                </div>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ })

});
//# sourceMappingURL=5.chunk.js.map