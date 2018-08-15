<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\PHPTutorial\WWW\geek\public/../app/ps\view\statistic\member_tree.html";i:1533112952;}*/ ?>
<div id="main" style="height:600px;"></div>

<script type="text/javascript">
    
    var myChart = echarts.init(document.getElementById('main'));

    myChart.setOption(option = {
        tooltip: {
            trigger: 'item',
            triggerOn: 'mousemove'
        },
        series: [
            {
                type: 'tree',

                data: [<?php echo $data; ?>],

                top: '1%',
                left: '7%',
                bottom: '1%',
                right: '20%',

                symbolSize: 15,

                label: {
                    normal: {
                        position: 'left',
                        verticalAlign: 'middle',
                        align: 'right',
                        fontSize: 15
                    }
                },

                leaves: {
                    label: {
                        normal: {
                            position: 'right',
                            verticalAlign: 'middle',
                            align: 'left'
                        }
                    }
                },

                expandAndCollaadmine: true,
                animationDuration: 550,
                animationDurationUpdate: 750
            }
        ]
    });
</script>