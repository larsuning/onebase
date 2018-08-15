<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\PHPTutorial\WWW\geek\public/../app/admin\view\statistic\member_tree.html";i:1533087617;}*/ ?>
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

                expandAndCollapse: true,
                animationDuration: 550,
                animationDurationUpdate: 750
            }
        ]
    });
</script>