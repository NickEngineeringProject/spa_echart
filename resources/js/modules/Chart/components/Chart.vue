<template>
    <div>
        <form @submit.prevent>
            <h2>Создание диаграммы</h2>
            <h3>Введите</h3>
            <div>
                <p>
                    <label>название или названия категории для отображения по оси x</label>
                    <input type="text" v-model="chart_name" />
                    <button @click="pushNameDataset()">Добавить</button>
                </p>
                <ul>
                    <li v-for="(name, index) in options.name_dataset">
                        <p>{{ name }} <button v-on:click="options.name_dataset.splice(index, 1)">Удалить</button></p>
                    </li>
                </ul>
            </div>
            <div>
                <p>
                    <label>данные для категории или категорий</label>
                    <input type="text" v-model="value" />
                    <button @click="pushValueDataset">Добавить</button>
                </p>
                <ul>
                    <li v-for="(value, index) in options.value_dataset">
                        <p>{{ value }} <button v-on:click="options.value_dataset.splice(index, 1)">Удалить</button></p>
                    </li>
                </ul>
            </div>
            <div>
                <p>
                    <label>выберите нужный тип или множество типов диаграммы</label>
                    <input type="text" v-model="chart_type"/>
                    <button @click="pushSeries()">Добавить</button>
                </p>
                <ul>
                    <li v-for="(type, index) in options.series">
                        <p>{{ type }}<button v-on:click="options.series.splice(index, 1)">Удалить</button></p>
                    </li>
                </ul>
            </div>
            <button v-on:click.prevent="request()">отправить/обновить данные</button>
        </form>
        <v-chart class="chart" :option="setOptions"/>
    </div>
</template>

<script>
import ChartForm from "./ChartForm";
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
    data() {
        return {
            chart_type: '',
            chart_name: '',
            value: '',
            options: { series: [], name_dataset: [], value_dataset: [], x_axis: [""], y_axis: [] },
            setOptions: {}
        }
    },
    methods: {
        pushSeries() {
            this.options.series.push(this.chart_type)
            this.chart_type = ''
        },
        pushNameDataset() {
            this.options.name_dataset.push(this.chart_name)
            this.chart_name = ''
        },
        pushValueDataset() {
            this.options.value_dataset.push(this.value.split(','))
            this.value = ''
        },
        request() {
            axios['post']('http://127.0.0.1:8000/api/chart', {
                "chart_type": this.options.series, // = ["line", "line"],
                "name_dataset": this.options.name_dataset, // = ["product", "2001", "2002"],
                "value_dataset": this.options.value_dataset, // = [["year-2001", "year-2002"], [20,40], [30, 50]],
                "x_axis" : this.options.x_axis = [""],
                "y_axis" : this.options.y_axis,
            }).then(response => { this.setOptions = response.data
                console.log(response.data)
            }).catch(error => console.log(error));
        }
    },
    components: {ChartForm, VChart },
    provide: {[THEME_KEY]: "dark"},
}
</script>

<style scoped>
.chart { height: 400px; }
</style>
