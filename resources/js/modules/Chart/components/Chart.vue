<template>
    <div >
<!--        <h2>Создание диаграммы</h2>-->
        <form action="#" method="post">
<!--            <div>-->
<!--                <label>Выберите тип диаграммы</label>-->
<!--                <input type="text" v-model="this.option.series[0].type">-->
<!--            </div>-->
<!--            <div>-->
<!--                <label>Введите данные или категории для отображения по оси</label>-->
<!--                <input type="text" v-model="option.xAxis.data">-->
<!--            </div>-->
<!--            <div>-->
<!--                <label>Введите данные то есть точки для постороения диаграммы</label>-->
<!--                <input type="text" v-model="option.series[0].data">-->
<!--            </div>-->
            <button v-on:click.prevent="request()">отправить/обновить данные</button>
        </form>
        {{this.options}}
        <v-chart class="chart" :option="options"/>
    </div>
</template>

<script>
import * as echarts from 'echarts/core';
import {
    DatasetComponent,
    GridComponent,
    LegendComponent,
    TitleComponent,
    ToolboxComponent,
    DataZoomComponent,
    VisualMapComponent,
    TimelineComponent,
    CalendarComponent,
    TooltipComponent
} from 'echarts/components';
import { LineChart, BarChart } from 'echarts/charts';
import { CanvasRenderer } from 'echarts/renderers';
import VChart, { THEME_KEY, UPDATE_OPTIONS_KEY } from "vue-echarts";
echarts.use([
    DatasetComponent,
    GridComponent,
    LegendComponent,
    TitleComponent,
    ToolboxComponent,
    DataZoomComponent,
    VisualMapComponent,
    TimelineComponent,
    CalendarComponent,
    LineChart,
    BarChart,
    CanvasRenderer,
    TooltipComponent
]);

export default {
    name: "Chart",
    components: { VChart },
    provide: {[THEME_KEY]: "dark"},
    // watch: {
    //     'options': function (last, newEl) {
    //         console.log(last, '1')
    //         console.log(newEl, '2')
    //         console.log(this.options)
    //     }
    // },
    data() {
        return {
            // option: {
            //     xAxis: {
            //         type: 'category',
            //         data: []
            //     },
            //     yAxis: {
            //         type: 'value'
            //     },
            //     series: [{
            //         data: [],
            //         type: 'line'
            //     }]
            // },
            options: {}
        };
    },
    methods: {
        async request() {
            const res = await axios.post('http://127.0.0.1:8000/api/chart', {
                "chart_type": ["line", "line", "line"],
                "name_dataset": ["year-1", "year-2", "year-3"],
                "value_dataset": [
                    [90, 100, 100],
                    [120, 130, 100],
                    [140, 200, 300]
                ],
                "x_axis" : [""],
                "y_axis" : []
                // "x_axis": this.option.xAxis.data ? this.option.xAxis.data.toString() : "",
                // "y_axis": this.option.yAxis.data ? this.option.xAxis.data.toString() : "",
                // "series_data": this.option.series[0].data.toString(),
                // "series_name": "",
                // "series_type": this.option.series[0].type
            })
            this.options = res.data
            console.log(res.data)
            // echarts.setOption(this.options)
        }
    }
}
</script>

<style scoped>
.chart { height: 400px; }
</style>
