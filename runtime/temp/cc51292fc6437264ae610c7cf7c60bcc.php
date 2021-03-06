<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"D:\PHPTutorial\WWW\geek\public/../app/admin\view\statistic\member_growth.html";i:1533087617;}*/ ?>
<div id="main" style="height:600px;"></div>

<script type="text/javascript">

    data = <?php echo $data; ?>;

    var dateList = data.map(function (item) { return item[0]; });
    var valueList = data.map(function (item) { return item[1]; });
    
    var valueSum = eval(valueList.join("+"));
    
    option = {

        visualMap: [{
            show: true,
            type: 'continuous',
            seriesIndex: 0,
            min: 0,
            max: valueSum
        }],

        title: [{
            left: 'center',
            text: '会员增长统计'
        }],
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [{
            data: dateList
        }],
        yAxis: [{
            max: valueSum,
            splitLine: {show: false}
        }],
        series: [{
            type: 'line',
            showSymbol: false,
            data: valueList
        }]
    };

    var myChart = echarts.init(document.getElementById('main'));

    myChart.setOption(option);
</script>