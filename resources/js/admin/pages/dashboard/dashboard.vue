<template>
    <div class="w-100">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-6">
                    <Evaluation_sector_line_chart/>
                </div>
                <div class="col-lg-6">
                    <Fair_decision_sector_line_chart/>
                </div>
                <div class="col-lg-12">
                    <Users_line_chart/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Evaluation_sector_line_chart from "./widgets/evaluation_sector_line_chart.vue";
import Fair_decision_sector_line_chart from "./widgets/fair_decision_sector_line_chart.vue";
import Users_line_chart from "./widgets/users_line_chart.vue";

export default {
    components: {
        Evaluation_sector_line_chart, Fair_decision_sector_line_chart, Users_line_chart
    },
    data() {
        return {
            core: window.core,
            UserInfo: window.core.UserInfo,
        };
    },
    methods: {},
    created() {

    },
    mounted() {
    }
};
</script>
