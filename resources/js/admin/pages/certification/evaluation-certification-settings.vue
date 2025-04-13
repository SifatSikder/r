<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <form class="w-100" @submit.prevent="SaveSettings">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h4 class="m-0"><strong class="text-secondary">Evaluation Certificates Settings</strong></h4>
                                <div class="">
                                    <router-link class="btn btn-sm btn-secondary rounded-pill px-3 me-2" :to="{name: 'EvaluationCertification'}">Back</router-link>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Save Changes</button>
                                </div>
                            </div>
                            <div class="card-body p-2 p-lg-5">

                                <div class="w-100" v-if="settings != null">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-2">
                                                        <h5>Certificate Logo</h5>
                                                        <input type="file" class="form-control" name="avatar"
                                                               @change="attachFile">
                                                        <div class="w-100 text-secondary"><small>Please upload 250x250 size certificate logo</small></div>
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                    <div class="form-group mb-5" :class="{'d-none': !settings.certificate_logo}"
                                                         v-if="settings.certificate_logo !== null">
                                                        <img :src="settings.certificate_logo_full"
                                                             style="width: 150px; height: 150px;border-radius: 50%;object-fit: cover;border: 5px solid #e6e6e6;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-2">
                                                        <h5>Certificate Background</h5>
                                                        <input type="file" class="form-control" name="avatar"
                                                               @change="attachBg">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                    <div class="form-group mb-5" :class="{'d-none': !settings.certificate_bg}"
                                                         v-if="settings.certificate_bg !== null">
                                                        <img :src="settings.certificate_bg_full"
                                                             style="width: 300px; height: 150px;object-fit: contain;border: 5px solid #e6e6e6;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-5">
                                            <div class="w-100">
                                                <h5>Participant's Name</h5>
                                            </div>
                                            <div class="w-100 bg-light p-3 border">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="form-group mb-4">
                                                            <label class="form-label"><strong>Text Color</strong></label>
                                                            <input type="color" class="form-control form-control-color" style="max-width: 100%" name="participant_name_color" v-model="settings.participant_name_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group mb-4">
                                                            <label class="form-label"><strong>Border Color</strong></label>
                                                            <input type="color" class="form-control form-control-color" style="max-width: 100%" name="participant_name_color" v-model="settings.participant_name_border_color" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group mb-4">
                                                            <label class="form-label"><strong>Font Size</strong></label>
                                                            <div class="input-group mb-3">
                                                                <input type="number" class="form-control" placeholder="Font Size" v-model="settings.participant_name_font_size" required>
                                                                <span class="input-group-text" id="basic-addon2">px</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="w-100">
                                                <h5>Certificate</h5>
                                            </div>
                                            <div class="w-100 bg-light p-3 border">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label class="form-label"><strong>Description Letter</strong></label>
                                                            <div class="w-100 text-success mb-2">
                                                                <small>For Dynamic evaluation name and date write short code like this:  <strong>[--Evaluation--]</strong>, <strong>[--Date--]</strong></small>
                                                            </div>
                                                            <textarea class="form-control" rows="5" name="description_letter" v-model="settings.description_letter" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group mb-4">
                                                            <label class="form-label"><strong>Signature</strong></label>
                                                            <input type="text" class="form-control" name="signature" v-model="settings.signature" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>


<script>
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import {createToaster} from "@meforma/vue-toaster";
const Toaster = createToaster({position: 'top-right'});

export default {
    components: {
        flatPickr
    },
    data() {
        return {
            Loading: false,
            settings: null,
            dateConfig: {
                disableMobile: true,
                altInput: true,
                altFormat: "d M, Y"
            }
        }
    },
    methods: {
        attachFile: function (event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("media_type", 1);
            this.Loading = true;
            ApiService.UPLOAD(ApiRoutes.MEDIA, formData, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.certificate_logo = res.data.file_path;
                    this.settings.certificate_logo_full = res.data.full_file_path;
                }
            })
        },
        attachBg: function (event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("media_type", 1);
            this.Loading = true;
            ApiService.UPLOAD(ApiRoutes.MEDIA, formData, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.settings.certificate_bg = res.data.file_path;
                    this.settings.certificate_bg_full = res.data.full_file_path;
                }
            })
        },
        getSettings() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.EvaluationCertificateSettings, {type: 'evaluation'}, (res) => {
                if (parseInt(res.status) === 200) {
                    this.settings = res.data;
                }
            })
        },
        SaveSettings() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.EvaluationCertificateSettingsUpdate, this.settings, (res) => {
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                    this.getSettings()
                }
            })
        }
    },
    created() {
        this.getSettings()
    },
    mounted() {
    }
};
</script>
