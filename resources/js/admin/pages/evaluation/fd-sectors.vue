<template>

    <div class="w-100">
        <div class="container">
            <div class="w-100">

                <form class="w-100" id="sector_form" @submit.prevent="Manage">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h4 class="m-0 p-0">Fair Decision in Specific Industry</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-vertical-middle">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Sector</th>
                                    <th class="text-center" style="width: 100px">Active</th>
                                    <th class="text-center" style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(sector, index) in Sectors">
                                    <td class="text-center">{{ index + 1 }}<input type="hidden" :name="'sectors['+index+'][uid]'" :value="sector.uid"></td>
                                    <td class="p-1"><input type="text" class="form-control border-0" :name="'sectors['+index+'][title]'" v-model="sector.title"></td>
                                    <td class="text-center">
                                        <input type="checkbox" style="width: 25px;height: 25px" :name="'sectors['+index+'][is_active]'" value="1" :checked="sector.is_active == 1">
                                    </td>
                                    <td class="text-center">
                                        <a @click="openSubSectors(sector)" class="btn btn-sm btn-warning me-2"><i class="fa fa-fw fa-cubes"></i></a>
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


    <div class="modal fade" id="SubSectorsModal">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="sub_sector_form" @submit.prevent="ManageSubSectors" class="w-100">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Fair Decision Sub Sectors</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped table-vertical-middle">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Section</th>
                                <th>Weight</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(sub_sector, index) in sub_sectors">
                                <td class="text-center">{{ index + 1 }}<input type="hidden" :name="'sectors['+index+'][uid]'" :value="sub_sector.uid"></td>
                                <td class="p-1"><input type="text" class="form-control border-0" :name="'sectors['+index+'][title]'" v-model="sub_sector.title"></td>
                                <td class="text-center" style="width: 100px">
                                    <input type="text" class="form-control bg-light" :name="'sectors['+index+'][weight]'" v-model="sub_sector.weight" required>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" :name="'sectors['+index+'][is_active]'" :value="1">
                                    <input type="hidden" :name="'sectors['+index+'][parent_id]'" :value="current_sector">
                                    <a @click="removeThisSubSector(index)" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <a @click="AddNewSubSector" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="fa fa-fw fa-plus"></i> New</a>
                        <div class="">
                            <input type="hidden" name="parent_id" :value="current_sector">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Save Changes</button>
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
            Sectors: [],
            current_sector: 0,
            sub_sectors: [],
        }
    },
    computed: {},
    watch: {},
    methods: {
        getAll() {
            const THIS = this;
            this.loading = true;
            ApiService.POST(ApiRoutes.fdSectorSectorGetAll, {type: 'fd'}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.Sectors = res.data;
                }
            })
        },
        AddNew() {
            this.Sectors.push({
                title: "",
                parent_id: 0
            });
        },
        Manage() {
            const sectors = new FormData(document.getElementById('sector_form'));
            this.loading = true
            ApiService.POST_FORM_DATA(ApiRoutes.fdSectorSectorManage, sectors, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    toaster.success(res.msg);
                }
            })
        },
        removeThis(index) {
            this.Sectors.splice(index, 1);
        },

        openSubSectors: function (sector) {
            const questionGroupModal = new bootstrap.Modal(document.getElementById('SubSectorsModal'));
            questionGroupModal.show();
            this.getSubSectors(sector.uid);
        },
        getSubSectors(sector_uid) {
            const THIS = this;
            THIS.current_sector = sector_uid;
            THIS.sub_sectors.length = 0;
            ApiService.POST(ApiRoutes.fdSectorSectorGetAll, {parent_id: sector_uid}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.sub_sectors = res.data;
                }
            })
        },
        ManageSubSectors() {
            const sectors = new FormData(document.getElementById('sub_sector_form'));
            this.loading = true
            ApiService.POST_FORM_DATA(ApiRoutes.fdSectorSectorManage, sectors, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    toaster.success(res.msg);
                }
            })
        },
        AddNewSubSector() {
            this.sub_sectors.push({
                title: "",
                parent_id: this.current_sector,
                is_active: 1
            });
        },
        removeThisSubSector(index) {
            this.sub_sectors.splice(index, 1);
        }
    },
    created() {
        this.getAll();
    },
    mounted() {
    },
}
</script>

