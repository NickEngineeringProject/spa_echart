<template>
    <div>
        <h2>Создание диаграммы</h2>
        <div>
            <p>
                <label>Выберите нужный тип или множество типов диаграммы</label>
                <input type="text" v-model="chart_type"/>
                <button v-on:click="option.series.push(chart_type)">Добавить</button>
            </p>
            <ul>
                <li v-for="(type, index) in option.series">
                    <p>{{ type }}<button v-on:click="option.series.splice(index, 1)">Удалить</button></p>
                </li>
            </ul>
        </div>
        <div>
            <p>
                <label>Выберите данные</label>
                <label>т.е. название категории, которая отобразится по оси x</label>
                <input type="text" v-model="chart_name" />
                <button v-on:click="option.name_dataset.push(chart_name)">Добавить</button>
            </p>
            <ul>
                <li v-for="(name, index) in option.name_dataset">
                    <p>{{ name }} <button v-on:click="option.name_dataset.splice(index, 1)">Удалить</button></p>
                </li>
            </ul>
        </div>
        <div>
            <p>
                <label>данные для категории</label>
                <input type="text" v-model="value" />
                <button v-on:click="option.value_dataset.push(value.split(','))">Добавить</button>
            </p>
            <ul>
                <li v-for="(value, index) in option.value_dataset">
                    <p>{{ value }} <button v-on:click="option.value_dataset.splice(index, 1)">Удалить</button></p>
                </li>
            </ul>
        </div>
        <form action="#" method="post">
            <button v-on:click.prevent="request()">отправить/обновить данные</button>
        </form>
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
    data() {
        return {
            chart_type: '',
            chart_name: '',
            value: '',
            option: {
                series: [],
                name_dataset: [],
                value_dataset: [],
                x_axis: [""],
                y_axis: []
            },
            options: {}
        };
    },
    methods: {
        request() {
            axios['post']('http://127.0.0.1:8000/api/chart', {
                "chart_type": this.option.series, // = ["line", "line"],
                "name_dataset": this.option.name_dataset, // = ["product", "2001", "2002"],
                "value_dataset": this.option.value_dataset, // = [["year-2001", "year-2002"], [20,40], [30, 50]],
                "x_axis" : this.option.x_axis = [""],
                "y_axis" : this.option.y_axis,
            }).then(response => { this.options = response.data
                console.log(response.data)
            }).catch(error => console.log(error));
        }
    }
}
</script>

<style scoped>
.chart { height: 400px; }
</style>
