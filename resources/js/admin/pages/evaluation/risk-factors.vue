<template>

    <div class="w-100">
        <div class="container">
            <div class="w-100">

                <form class="w-100" id="risk_factor_form" @submit.prevent="Manage">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h4 class="m-0 p-0">Risk Factors</h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped table-vertical-middle">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Risk Factor</th>
                                    <th class="text-center">Software</th>
                                    <th class="text-center">Hardware</th>
                                    <th class="text-center">Ethical</th>
                                    <th class="text-center">Legal</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(factor, index) in RiskFactors">
                                    <td class="text-center">{{ index + 1 }}<input type="hidden" :name="'risk_factors['+index+'][uid]'" :value="factor.uid"></td>
                                    <td class="p-1"><input type="text" class="form-control border-0" :name="'risk_factors['+index+'][title]'" :value="factor.title"></td>
                                    <td class="text-center"><input style="width: 25px;height: 25px;" type="checkbox" :name="'risk_factors['+index+'][software]'" value="1" :checked="factor.software == 1"></td>
                                    <td class="text-center"><input style="width: 25px;height: 25px;" type="checkbox" :name="'risk_factors['+index+'][hardware]'" value="1" :checked="factor.hardware == 1"></td>
                                    <td class="text-center"><input style="width: 25px;height: 25px;" type="checkbox" :name="'risk_factors['+index+'][ethical]'" value="1" :checked="factor.ethical == 1"></td>
                                    <td class="text-center"><input style="width: 25px;height: 25px;" type="checkbox" :name="'risk_factors['+index+'][legal]'" value="1" :checked="factor.legal == 1"></td>
                                    <td class="text-center">
                                        <a @click="removeThis(index)" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer py-3 d-flex justify-content-between align-items-center">
                            <a @click="AddNew" class="btn btn-outline-secondary rounded-pill"><i class="fa fa-fw fa-plus"></i> Add New</a>
                            <button class="btn btn-danger rounded-pill">Save Changes</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</template>


<script>
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";

const toaster = createToaster({
    position: 'top-right'
});

export default {
    data() {
        return {
            loading: false,
            RiskFactors: []
        }
    },
    computed: {},
    watch: {},
    methods: {
        getAll() {
            const THIS = this;
            this.loading = true
            ApiService.POST(ApiRoutes.RiskFactorGetAll, this.password, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.RiskFactors = res.data;
                }
            })
        },
        Manage() {
            const risk_factors = new FormData(document.getElementById('risk_factor_form'));
            this.loading = true
            ApiService.POST_FORM_DATA(ApiRoutes.RiskFactorManage, risk_factors, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    toaster.success(res.msg);
                }
            })
        },
        AddNew() {
            this.RiskFactors.push({
                title: "",
                software: 0,
                hardware: 0,
                ethical: 0,
                legal: 0,
            });
        },
        removeThis(index) {
            this.RiskFactors.splice(index, 1);
        }
    },
    created() {
        this.getAll();
    },
    mounted() {
    },
}
</script>

