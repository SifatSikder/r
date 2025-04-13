<template>
    <div class="body-loading" v-if="chartReady === false">
        <div class="w-100 text-center">
            <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <strong class="text-black-50">Registered Users</strong>
            <div class="d-inline-block">
                <flat-pickr
                    v-model="selected_date"
                    :config="dateConfig"
                    @on-change="onDateChange"
                    class="form-control"
                    placeholder="Select date"
                    name="date"/>
            </div>
        </div>
        <div class="card-body" style="height: 480px" v-if="chartReady">
            <Line :data="data" :options="options"/>
        </div>
    </div>
</template>


<script>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import {Line} from 'vue-chartjs'
import ApiService from "../../../services/ApiService";
import ApiRoutes from "../../../services/ApiRoutes";
import flatPickr from 'vue-flatpickr-component';
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect"
import 'flatpickr/dist/flatpickr.css';
import 'flatpickr/dist/plugins/monthSelect/style.css';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)
export default {
    components: {
        Line, flatPickr
    },
    data() {
        return {
            core: window.core,
            chartReady: false,
            selected_date: null,
            dateConfig: {
                disableMobile: true,
                altInput: true,
                altFormat: "F Y",
                plugins: [
                    new monthSelectPlugin({
                        altInput: true,
                        shorthand: true,
                        dateFormat: "Y-m-01",
                        altFormat: "F, Y",
                    })
                ]
            },
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    methods: {
        evaluation_sector_charts(){
            this.chartReady = false;
            this.data.labels.length = 0;
            this.data.datasets.length = 0;
            ApiService.POST(ApiRoutes.RegisteredUsersCharts, {selected_date: this.selected_date}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.data.labels = res.data.labels;
                    res.data.users.forEach((v) => {
                        this.data.datasets.push({
                            data: v.registered,
                            label: v.name,
                            tension: 0.3,
                            borderColor: v.color,
                            backgroundColor: v.color
                        })
                    });
                    this.chartReady = true;
                }
            })
        },
        onDateChange(selectedDates, dateStr, instance){
            this.selected_date = dateStr;
            this.evaluation_sector_charts();
        }
    },
    created() {
        this.evaluation_sector_charts();
    },
    mounted() {
    }
};
</script>
