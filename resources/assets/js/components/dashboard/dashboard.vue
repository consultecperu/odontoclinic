<template>
    <div>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-users"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Visitors</p>
                                    <h4 class="card-title">1,294</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-interface-6"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Subscribers</p>
                                    <h4 class="card-title">1303</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-success card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-graph"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Sales</p>
                                    <h4 class="card-title">$ 1,345</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-secondary card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Order</p>
                                    <h4 class="card-title">576</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Users Statistics</div>
                            <div class="card-tools">
                                <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
                                    <span class="btn-label">
                                        <i class="la la-pencil"></i>
                                    </span>
                                    Export
                                </a>
                                <a href="#" class="btn btn-info btn-border btn-round btn-sm">
                                    <span class="btn-label">
                                        <i class="la la-print"></i>
                                    </span>
                                    Print
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users Percentage</h4>
                        <p class="card-category">
                        Users percentage this month</p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="usersChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-card-no-pd">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <h4 class="card-title">Users Geolocation</h4>
                            <div class="card-tools">
                                <a href="#" class="btn btn-primary btn-icon-only"><span class="icon flaticon-down-arrow"></span></a>
                                <a href="#" class="btn btn-primary btn-icon-only"><span class="icon flaticon-repeat"></span></a>
                                <a href="#" class="btn btn-primary btn-icon-only"><span class="icon flaticon-cross"></span></a>
                            </div>
                        </div>
                        <p class="card-category">
                        Map of the distribution of users around the world</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="flag">
                                                        <img src="/img/flags/id.png" alt="indonesia">
                                                    </div>
                                                </td>
                                                <td>Indonesia</td>
                                                <td class="text-right">
                                                    2.320
                                                </td>
                                                <td class="text-right">
                                                    42.18%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flag">
                                                        <img src="/img/flags/us.png" alt="united states">
                                                    </div>
                                                </td>
                                                <td>USA</td>
                                                <td class="text-right">
                                                    240
                                                </td>
                                                <td class="text-right">
                                                    4.36%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flag">
                                                        <img src="/img/flags/au.png" alt="australia">
                                                    </div>
                                                </td>
                                                <td>Australia</td>
                                                <td class="text-right">
                                                    119
                                                </td>
                                                <td class="text-right">
                                                    2.16%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flag">
                                                        <img src="/img/flags/ru.png" alt="russia">
                                                    </div>
                                                </td>
                                                <td>Russia</td>
                                                <td class="text-right">
                                                    1.081
                                                </td>
                                                <td class="text-right">
                                                    19.65%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flag">
                                                        <img src="/img/flags/cn.png" alt="china">
                                                    </div>
                                                </td>
                                                <td>China</td>
                                                <td class="text-right">
                                                    1.100
                                                </td>
                                                <td class="text-right">
                                                    20%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="flag">
                                                        <img src="/img/flags/br.png" alt="brazil">
                                                    </div>
                                                </td>
                                                <td>Brasil</td>
                                                <td class="text-right">
                                                    640
                                                </td>
                                                <td class="text-right">
                                                    11.63%
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mapcontainer">
                                    <div id="map-example" class="vmap"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-card-no-pd">
            <div class="col-md-4 mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-mediumbold mt-1">My Balance</p>
                        <h4 class="text-primary"><b>$ 3,018</b></h4>
                        <a href="#" class="btn btn-primary btn-full text-left mt-3 mb-3"><i class="la la-plus"></i> Add Balance</a>
                    </div>
                    <div class="card-footer mt-auto">
                        <ul class="nav">
                            <li class="nav-item"><a class="btn btn-default btn-link" href="#"><i class="la la-history"></i> History</a></li>
                            <li class="nav-item ml-auto"><a class="btn btn-default btn-link" href="#"><i class="la la-refresh"></i> Refresh</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="progress-card">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Profit</span>
                                <span class="text-muted fw-bold"> $3K</span>
                            </div>
                            <div class="progress mb-2" style="height: 7px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="78%"></div>
                            </div>
                        </div>
                        <div class="progress-card">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Orders</span>
                                <span class="text-muted fw-bold"> 576</span>
                            </div>
                            <div class="progress mb-2" style="height: 7px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="65%"></div>
                            </div>
                        </div>
                        <div class="progress-card">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Tasks Complete</span>
                                <span class="text-muted fw-bold"> 70%</span>
                            </div>
                            <div class="progress mb-2" style="height: 7px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="70%"></div>
                            </div>
                        </div>
                        <div class="progress-card">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Open Rate</span>
                                <span class="text-muted fw-bold"> 60%</span>
                            </div>
                            <div class="progress mb-2" style="height: 7px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="60%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <p class="fw-mediumbold mt-1">Statistic</p>
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="la la-pie-chart text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Number</p>
                                    <h4 class="card-title">150GB</h4>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="la la-heart-o text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Followers</p>
                                    <h4 class="card-title">+45K</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card card-tasks">
                    <div class="card-header ">
                        <div class="card-head-row">
                            <h4 class="card-title">Tasks</h4>
                            <div class="card-tools">
                                <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-contact" data-toggle="pill" href="#pills-contact" role="tab" aria-selected="false">Month</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-full-width">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input  select-all-checkbox" type="checkbox" data-select="checkbox" data-target=".task-select">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th>Task</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input task-select" type="checkbox">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Planning new project structure</td>
                                        <td class="td-actions text-center">
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary">
                                                    <i class="la la-edit"></i>
                                                </button>
                                                <button type="button" data-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">
                                                    <i class="la la-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input task-select" type="checkbox">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Update Fonts</td>
                                        <td class="td-actions text-center">
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary">
                                                    <i class="la la-edit"></i>
                                                </button>
                                                <button type="button" data-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">
                                                    <i class="la la-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input task-select" type="checkbox">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Add new Post
                                        </td>
                                        <td class="td-actions text-center">
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary">
                                                    <i class="la la-edit"></i>
                                                </button>
                                                <button type="button" data-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">
                                                    <i class="la la-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input task-select" type="checkbox">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>Finalise the design proposal</td>
                                        <td class="td-actions text-center">
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="tooltip" title="Edit Task" class="btn btn-link btn-primary">
                                                    <i class="la la-edit"></i>
                                                </button>
                                                <button type="button" data-toggle="tooltip" title="Remove" class="btn btn-link btn-danger">
                                                    <i class="la la-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <div class="stats">
                            <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Task Progress</h4>
                    </div>
                    <div class="card-body">
                        <div id="task-complete" class="chart-circle mt-4 mb-3"></div>
                    </div>
                    <div class="card-footer">
                        <div class="legend"><i class="la la-circle text-primary"></i> Completed</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-title">Suggested People</div>
                        <div class="card-list">
                            <div class="item-list">
                                <img src="/img/jm_denis.jpg" alt="denis" class="small-pic">
                                <div class="info-user ml-3">
                                    <div class="username">Jimmy Denis</div>
                                    <div class="status">Graphic Designer</div>
                                </div>
                                <a href="#" class="btn btn-add">
                                    <i class="la la-plus"></i>
                                </a>
                            </div>
                            <div class="item-list">
                                <img src="/img/chadengle.jpg" alt="chad" class="small-pic">
                                <div class="info-user ml-3">
                                    <div class="username">Chad</div>
                                    <div class="status">CEO Zeleaf</div>
                                </div>
                                <a href="#" class="btn btn-add">
                                    <i class="la la-plus"></i>
                                </a>
                            </div>
                            <div class="item-list">
                                <img src="/img/mlane.jpg" alt="john doe" class="small-pic">
                                <div class="info-user ml-3">
                                    <div class="username">Jhon doe</div>
                                    <div class="status">Content Writer</div>
                                </div>
                                <a href="#" class="btn btn-add">
                                    <i class="la la-plus"></i>
                                </a>
                            </div>
                            <div class="item-list">
                                <img src="/img/talha.jpg" alt="talha" class="small-pic">
                                <div class="info-user ml-3">
                                    <div class="username">Talha</div>
                                    <div class="status">Front End Designer</div>
                                </div>
                                <a href="#" class="btn btn-add">
                                    <i class="la la-plus"></i>
                                </a>
                            </div>
                            <div class="item-list">
                                <img src="/img/sauro.jpg" alt="sauro" class="small-pic">
                                <div class="info-user ml-3">
                                    <div class="username">Sauro</div>
                                    <div class="status">Back End Developer</div>
                                </div>
                                <a href="#" class="btn btn-add">
                                    <i class="la la-plus"></i>
                                </a>
                            </div>
                            <div class="item-list">
                                <img src="/img/arashmil.jpg" alt="arash mil" class="small-pic">
                                <div class="info-user ml-3">
                                    <div class="username">Arash Mil</div>
                                    <div class="status">Content Writer</div>
                                </div>
                                <a href="#" class="btn btn-add">
                                    <i class="la la-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>
<script>
import mixin from '../../mixins.js'
export default {
    name: 'dashboard',
    mixins : [mixin],
    mounted(){
        $('#map-example').vectorMap(
        {
            map: 'world_en',
            backgroundColor: 'transparent',
            borderColor: '#fff',
            borderWidth: 2,
            color: '#e4e4e4',
            enableZoom: true,
            hoverColor: '#35cd3a',
            hoverOpacity: null,
            normalizeFunction: 'linear',
            scaleColors: ['#b6d6ff', '#005ace'],
            selectedColor: '#35cd3a',
            selectedRegions: ['ID', 'RU', 'US', 'AU', 'CN', 'BR'],
            showTooltip: true,
            onRegionClick: function(element, code, region)
            {
                return false;
            },
            onResize: function (element, width, height) {
                console.log('Map Size: ' +  width + 'x' +  height);
            },
        });

        //Chart

        var ctx = document.getElementById('statisticsChart').getContext('2d');

        var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#177dff');
        gradientStroke.addColorStop(1, '#80b6f4');

        var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
        gradientFill.addColorStop(0, "rgba(23, 125, 255, 0.7)");
        gradientFill.addColorStop(1, "rgba(128, 182, 244, 0.3)");

        var gradientStroke2 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke2.addColorStop(0, '#f3545d');
        gradientStroke2.addColorStop(1, '#ff8990');

        var gradientFill2 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientFill2.addColorStop(0, "rgba(243, 84, 93, 0.7)");
        gradientFill2.addColorStop(1, "rgba(255, 137, 144, 0.3)");

        var gradientStroke3 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke3.addColorStop(0, '#fdaf4b');
        gradientStroke3.addColorStop(1, '#ffc478');

        var gradientFill3 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientFill3.addColorStop(0, "rgba(253, 175, 75, 0.7)");
        gradientFill3.addColorStop(1, "rgba(255, 196, 120, 0.3)");

        var statisticsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [ {
                    label: "Subscribers",
                    borderColor: gradientStroke2,
                    pointBackgroundColor: gradientStroke2,
                    pointRadius: 0,
                    backgroundColor: gradientFill2,
                    legendColor: '#f3545d',
                    fill: true,
                    borderWidth: 1,
                    data: [154, 184, 175, 203, 210, 231, 240, 278, 252, 312, 320, 374]
                }, {
                    label: "New Visitors",
                    borderColor: gradientStroke3,
                    pointBackgroundColor: gradientStroke3,
                    pointRadius: 0,
                    backgroundColor: gradientFill3,
                    legendColor: '#fdaf4b',
                    fill: true,
                    borderWidth: 1,
                    data: [256, 230, 245, 287, 240, 250, 230, 295, 331, 431, 456, 521]
                }, {
                    label: "Active Users",
                    borderColor: gradientStroke,
                    pointBackgroundColor: gradientStroke,
                    pointRadius: 0,
                    backgroundColor: gradientFill,
                    legendColor: '#177dff',
                    fill: true,
                    borderWidth: 1,
                    data: [542, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 900]
                }]
            },
            options : {
                responsive: true, 
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    bodySpacing: 4,
                    mode:"nearest",
                    intersect: 0,
                    position:"nearest",
                    xPadding:10,
                    yPadding:10,
                    caretPadding:10
                },
                layout:{
                    padding:{left:15,right:15,top:15,bottom:15}
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "500",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "500"
                        }
                    }]
                }, 
                legendCallback: function(chart) { 
                    var text = []; 
                    text.push('<ul class="' + chart.id + '-legend html-legend">'); 
                    for (var i = 0; i < chart.data.datasets.length; i++) { 
                        text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>'); 
                        if (chart.data.datasets[i].label) { 
                            text.push(chart.data.datasets[i].label); 
                        } 
                        text.push('</li>'); 
                    } 
                    text.push('</ul>'); 
                    return text.join(''); 
                }  
            }
        });

        var myLegendContainer = document.getElementById("myChartLegend");

        // generate HTML legend
        myLegendContainer.innerHTML = statisticsChart.generateLegend();

        // bind onClick event to all LI-tags of the legend
        var legendItems = myLegendContainer.getElementsByTagName('li');
        for (var i = 0; i < legendItems.length; i += 1) {
            legendItems[i].addEventListener("click", legendClickCallback, false);
        }


        var ctx2 = document.getElementById('usersChart').getContext('2d');

        var usersChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [50, 35, 15],
                    "backgroundColor":["rgb(23, 125, 255)","rgb(255, 100, 109)","rgb(253, 190, 70)"],
                    borderWidth: 0
                }],
                labels: ['Active Users', 'Subscribers' , 'New Visitors'] 
            },
            options : {
                responsive: true, 
                maintainAspectRatio: false,
                legend: {
                    position : 'bottom',
                    labels : {
                        fontColor: 'rgb(154, 154, 154)',
                        fontSize: 11,
                        usePointStyle : true,
                        padding: 20
                    }
                },
                pieceLabel: {
                    render: 'percentage',
                    fontColor: 'white',
                    fontSize: 14,
                },
                tooltips: false,
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

    },
    data() {
        return {

        }
    },
    

}
</script>
<style scoped>

</style>
