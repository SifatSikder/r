<template>
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="w-100" v-if="risk_evaluation != null">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <a @click="goBack" class="btn btn-sm btn-outline-secondary"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
                        <h3 class="text-center m-0" v-if="risk_analysis === 'risk'"><strong>Risk Evaluation Process</strong></h3>
                        <h3 class="text-center m-0" v-if="risk_analysis === 'fair'"><strong>Fair Decision Analysis</strong></h3>
                        <a class="invisible"><i class="fa fa-fw fa-arrow-left"></i> <span class="d-sm-inline d-none">Back</span></a>
                    </div>
                    <div class="card-body py-4 px-5">

                        <div class="w-100" v-if="risk_analysis === 'risk'">
                            <h2 class="mb-4 text-center"><strong class="text-secondary">Please select one Domain</strong></h2>
                        </div>
                        <div class="w-100" v-if="risk_analysis === 'fair'">
                            <h2 class="mb-4 text-center" v-if="sub_sectors.length == 0"><strong class="text-secondary">Please select one Domain</strong></h2>
                        </div>


                        <div class="w-100 mt-3">
                            <div class="row" v-if="sub_sectors.length == 0">
                                <div v-for="(sector, index) in sectors" class="col-lg-6" :class="{'offset-lg-3': isOddSector(index)}">
                                    <div class="w-100 mb-3">
                                        <div class="w-100 btn py-4"
                                             :class="{
                                            'disable-element': sector.is_active == 0,
                                            'btn-outline-success':risk_evaluation.evaluation_sector !== sector.uid,
                                            'btn-success':risk_evaluation.evaluation_sector === sector.uid
                                        }" @click="addSector(sector)">
                                            <h5 class="m-0"><i class="fa fa-fw fa-2x fa-cubes"></i> <br> {{ sector.title }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="sub_sectors.length > 0">
                                <div v-for="(sub_sector, sub_index) in sub_sectors" class="col-lg-6" :class="{'offset-lg-3': isOddSubSector(sub_index)}">
                                    <div class="w-100 mb-3">
                                        <div class="w-100 btn py-4"
                                             :class="{
                                            'btn-outline-success':risk_evaluation.evaluation_sub_sector !== sub_sector.uid,
                                            'btn-success':risk_evaluation.evaluation_sub_sector === sub_sector.uid
                                        }" @click="addSubSector(sub_sector)">
                                            <h5 class="m-0"><i class="fa fa-fw fa-2x fa-cubes"></i> <br> {{ sub_sector.title }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 mt-5" v-if="risk_analysis === 'fair'">
                            <h2 class="mb-4 text-center" v-if="sub_sectors.length > 0">
                                <a @click="startFairAnalysis" class="btn btn-success rounded-pill px-4 py-3">Start Analysis <i class="fa fa-fw fa-arrow-right"></i></a>
                            </h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
import ApiService from "../services/ApiService";
import ApiRoutes from "../services/ApiRoutes";

export default {
    data() {
        return {
            risk_evaluation: null,
            sub_sectors: [],
            sectors: [],
            risk_analysis: ''
        }
    },
    computed: {},
    watch: {},
    methods: {
        isOddSector(index){
            if(index > 0 && index % 2 === 0 && (index+1) === this.sectors.length){
                return true;
            } else {
                return false;
            }
        },
        isOddSubSector(index){
            if(index > 0 && index % 2 === 0 && (index+1) === this.sub_sectors.length){
                return true;
            } else {
                return false;
            }
        },
        evaluationSectors() {
            if(this.risk_analysis === 'fair'){
                ApiService.POST(ApiRoutes.fdSectors, {}, (res) => {
                    if (parseInt(res.status) === 200) {
                        this.sectors = res.data
                    }
                })
            } else {
                ApiService.POST(ApiRoutes.EvaluationSectors, {}, (res) => {
                    if (parseInt(res.status) === 200) {
                        this.sectors = res.data
                    }
                })
            }
        },
        addSector: function (sector) {
            this.risk_evaluation.evaluation_sector = sector.uid;
            if(sector.sub_sectors.length > 0){
                this.sub_sectors = sector.sub_sectors;
            } else {
                this.submitForm()
            }
        },
        addSubSector: function (sector) {
            if(this.risk_analysis === 'risk'){
                this.risk_evaluation.evaluation_sub_sector = sector.uid;
                this.submitForm()
            }
        },
        startFairAnalysis: function (sector) {
            if(this.risk_analysis === 'fair'){
                this.risk_evaluation.evaluation_sub_sector = this.sub_sectors[0].uid;
                this.submitForm()
            }
        },
        submitForm: function () {
            localStorage.setItem('risk_evaluation', JSON.stringify(this.risk_evaluation));
            if(this.risk_evaluation.evaluation_sub_sector == null){
                this.$router.push({name: 'EtQuestionsDomain', params: {domain: this.risk_evaluation.evaluation_sector}})
            } else {
                if(this.risk_analysis === 'risk'){
                    this.$router.push({name: 'EtQuestionsDomain', params: {domain: this.risk_evaluation.evaluation_sector}, query: {section: this.risk_evaluation.evaluation_sub_sector}})
                }
                if(this.risk_analysis === 'fair'){
                    this.$router.push({name: 'EtaFdQuestions', params: {domain: this.risk_evaluation.evaluation_sector}})
                }
            }
        },
        goBack(){
            this.$router.push({name: 'EtEta'})
        }
    },
    created() {
        if (localStorage.getItem('risk_evaluation') == null) {
            this.$router.push({name: 'ProjectIntro'})
        } else {
            this.risk_evaluation = JSON.parse(localStorage.getItem('risk_evaluation'));
        }

        if (localStorage.getItem('risk_analysis') != null) {
            this.risk_analysis = localStorage.getItem('risk_analysis');
        } else {
            this.risk_analysis = 'risk';
            localStorage.setItem('risk_analysis', this.risk_analysis);
        }
        this.evaluationSectors();
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>

