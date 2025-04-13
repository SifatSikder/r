<template>
    <div class="w-100">
        <div class="container">
            <div class="w-100 text-center py-5" v-if="risk_evaluation == null">

                <div class="w-100 text-center mb-5" v-if="loadingStep === 0">
                    <h5 class="w-100 text-center">
                        <strong>Processing Report...</strong>
                        <i class="fa fa-fw fa-spin fa-circle-o-notch"></i>
                    </h5>
                </div>
                <div class="w-100 text-center mb-5" v-if="loadingStep === 1">
                    <div class="alert alert-warning">
                        <strong>Processing Your Submitted Answers...</strong>
                        <div class="progress border border-warning rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" :style="{width: progress+'%'}"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-center mb-5" v-if="loadingStep === 2">
                    <div class="alert alert-primary">
                        <strong>Evaluating Risk For Specific Sector...</strong>
                        <div class="progress border border-primary rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" :style="{width: progress+'%'}"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-center" v-if="loadingStep === 3">
                    <div class="alert alert-success">
                        <strong>Measuring the Risk...</strong>
                        <div class="progress border border-success rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" :style="{width: progress+'%'}"></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-center" v-if="loadingStep === 4">
                    <div class="alert alert-success">
                        <strong>Generating Visual Report of Risk Evaluation </strong>
                        <div class="progress border border-success rounded-pill mt-3">
                            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" :style="{width: progress+'%'}"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-100" v-if="risk_evaluation != null">

                <div class="row d-flex align-items-center">
                    <div class="col-lg-3">
                        <router-link :to="{name: 'Dashboard'}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-fw fa-arrow-left"></i> Back to Dashboard</router-link>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="text-center text-dark m-0"><strong>{{ risk_evaluation.evaluation.project.name }}</strong></h2>
                        <h5 class="text-center mt-2">
                            <span class="badge bg-primary" v-if="risk_evaluation.evaluation.category === 'et'">General Risk Evaluation</span>
                            <span class="badge bg-primary" v-if="risk_evaluation.evaluation.category === 'eta'">Specific Industry Risk Evaluation</span>
                            <span class="badge bg-primary" v-if="risk_evaluation.evaluation.category === 'nt'">Non Tech Risk Evaluation</span>
                            <span class="badge bg-info" v-if="risk_evaluation.evaluation.category === 'fd'">General Fair Decision</span>
                            <span class="badge bg-primary" v-if="risk_evaluation.evaluation.category === 'eta-fd'">Specific Industry Fair Decision</span>
                        </h5>
                    </div>
                    <div class="col-lg-2 offset-lg-1">
                        <div class="w-100 p-3 bg-light border">
                            <table class="table table-borderless m-0">
                                <tr>
                                    <td class="p-0 text-center"><span class="w-100 badge bg-white border border-dark text-dark">No Risk</span></td>
                                </tr>
                                <tr>
                                    <td class="p-0 text-center"><span class="w-100 badge bg-low">Low Risk</span></td>
                                </tr>
                                <tr>
                                    <td class="p-0 text-center"><span class="w-100 badge bg-limited">Limited Risk</span></td>
                                </tr>
                                <tr>
                                    <td class="p-0 text-center"><span class="w-100 badge bg-high">High Risk</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 text-center mt-3 mb-3">

                        <div class="w-100 bg-light border p-3 text-center">
                            <h4 class="d-inline-block px-5 pb-3 border-bottom border-dark"><strong>Risk Level</strong></h4>
                            <br><br>
                            <strong>No Risk <span class="badge bg-white border border-dark text-dark">{{ risk_evaluation.riskReport.riskPercentage.No }}%</span></strong>
                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                            <strong>Low Risk <span class="badge bg-low text-white">{{ risk_evaluation.riskReport.riskPercentage.Low }}%</span></strong>
                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                            <strong>Limited Risk <span class="badge bg-limited text-white">{{ risk_evaluation.riskReport.riskPercentage.Limited }}%</span></strong>
                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                            <strong>High Risk <span class="badge bg-high text-white">{{ risk_evaluation.riskReport.riskPercentage.High }}%</span></strong>
                        </div>

                    </div>
                </div>

                <div class="row" v-if="risk_evaluation.riskReport.riskPercentage.No === 100 && UserInfo.subscription_type === 'premium'">
                    <div class="col-lg-12 text-center mb-3">
                        <div class="w-100 border border-success border-3 p-3 text-center">
                            <h3 class="text-success"><strong>Congratulations!</strong></h3>
                            <h4 class="text-success">You have successfully completed the Risk evaluation by resolving the mitigation strategies.</h4>
                            <p class="text-center mt-3">
                                <a target="_blank" :href="certificateUrl()" class="btn btn-success">Download Certificate</a>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="row" v-if="risk_evaluation.evaluation.category === 'et'">
                    <div class="col-lg-6" v-for="(section,index) in risk_evaluation.riskReport.sections">
                        <div class="w-100">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center py-3">
                                    <h4 class="m-0 p-0"><strong>{{ section.title }}</strong></h4>
                                </div>
                                <div class="card-body" style="min-height: 150px">
                                    <div class="w-100">
                                        <template v-if="section.risk_report === undefined">
                                            <div class="w-100 text-center">
                                                <p class="alert alert-warning">You didn't answer <strong>{{ section.title }}</strong> section questions.</p>
                                                <a class="btn btn-sm btn-primary" :href="'/risk-evaluation/et-questions?ev='+risk_evaluation.evaluation._id+'&cgr='+index">View Questions</a>
                                            </div>
                                        </template>
                                        <template v-if="section.risk_report !== undefined">
                                            <div class="w-100" v-for="(rl,index) in section.risk_report.questionRiskLevel">
                                                <div
                                                    @click="OpenThisQuestion(section,index,rl)"
                                                    class="rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1"
                                                    :class="['bg-'+rl.toLowerCase(), 'border-'+rl.toLowerCase()]" style="height: 50px;width: 50px;float: left">
                                                    <strong class="text-uppercase">{{ index }}</strong>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="risk_evaluation.evaluation.category === 'eta'">
                    <div class="col-lg-12">
                        <div class="w-100">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h4 class="m-0 p-0 text-center"><strong>Risk Evaluation</strong></h4>
                                </div>
                                <div class="card-body" style="min-height: 150px">
                                    <div class="w-100">
                                        <div class="w-100" v-for="(rl,index) in risk_evaluation.riskReport.risk_report.questionRiskLevel">
                                            <div
                                                @click="OpenThisQuestion('eta',index,rl)"
                                                class="rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1"
                                                :class="['bg-'+rl.toLowerCase(), 'border-'+rl.toLowerCase()]" style="height: 75px;width: 75px;float: left">
                                                <strong class="text-uppercase">{{ index }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="risk_evaluation.evaluation.category === 'eta-fd'">
                    <div :class="is_last_even(index)" v-for="(section,index) in risk_evaluation.riskReport.sections">
                        <div class="w-100">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center py-3">
                                    <h4 class="m-0 p-0"><strong>{{ section.title }}</strong></h4>
                                </div>
                                <div class="card-body">
                                    <div class="w-100">
                                        <template v-if="section.risk_report === undefined">
                                            <div class="w-100 text-center">
                                                <p class="alert alert-warning">You didn't answer <strong>{{ section.title }}</strong> section questions.</p>
                                                <a class="btn btn-sm btn-primary" :href="'/risk-evaluation/et-questions?ev='+risk_evaluation.evaluation._id+'&cgr='+index">View Questions</a>
                                            </div>
                                        </template>
                                        <template v-if="section.risk_report !== undefined">
                                            <div class="w-100" v-for="(rl,rlIndex) in section.risk_report.questionRiskLevel">
                                                <div
                                                    @click="OpenThisQuestion('eta-fd',rlIndex, rl, section)"
                                                    class="rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1"
                                                    :class="['bg-'+rl.toLowerCase(), 'border-'+rl.toLowerCase()]" style="height: 50px;width: 50px;float: left">
                                                    <strong class="text-uppercase">{{ rlIndex }}</strong>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="risk_evaluation.evaluation.category === 'nt'">
                    <div class="col-lg-12">
                        <div class="w-100">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h4 class="m-0 p-0 text-center"><strong>Risk Evaluation</strong></h4>
                                </div>
                                <div class="card-body">
                                    <div class="w-100">
                                        <div class="w-100 text-center">
                                            <div class="d-inline-block" v-for="(rl,index) in risk_evaluation.riskReport.risk_report.questionRiskLevel">
                                                <div
                                                    @click="OpenThisQuestion('nt',index,rl)"
                                                    class="rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1"
                                                    :class="['bg-'+rl.toLowerCase(), 'border-'+rl.toLowerCase()]" style="height: 75px;width: 75px;float: left">
                                                    <strong class="text-uppercase">{{ index }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="risk_evaluation.evaluation.category === 'fd'">
                    <div class="col-lg-12">
                        <div class="w-100">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h4 class="m-0 p-0 text-center"><strong>General Fair Decision</strong></h4>
                                </div>
                                <div class="card-body">
                                    <div class="w-100">
                                        <div class="w-100 text-center">
                                            <div class="d-inline-block" v-for="(rl,index) in risk_evaluation.riskReport.risk_report.questionRiskLevel">
                                                <div
                                                    @click="OpenThisQuestion('fd',index,rl)"
                                                    class="rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1"
                                                    :class="['bg-'+rl.toLowerCase(), 'border-'+rl.toLowerCase()]" style="height: 75px;width: 75px;float: left">
                                                    <strong class="text-uppercase">{{ index }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-lg-6">
                        <div class="w-100 bg-white border p-5 position-relative" style="height: 500px;overflow-y: auto; overflow-x: hidden;display: inline-block">
                            <h3 class="mb-4 position-sticky"><strong>Risk Level & Mitigation Strategies</strong></h3>
                            <h6 v-if="UserInfo.subscription_type === 'premium'" class="m-0 p-0" v-html="ReportGPT"></h6>
                            <h6 v-if="UserInfo.subscription_type === 'free'" class="alert alert-warning text-center">
                                <strong>Mitigation Strategies</strong> is a premium feature. <br>
                                You must subscribe to premium plan to have all premium features. <br> <br>
                                <a href="/pricing" class="btn btn-sm btn-success">Choose Plan</a>
                            </h6>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="w-100 bg-white border p-3 text-center" style="height: 500px;overflow: hidden;display: inline-block" v-if="chart != null">
                            <Pie :data="chart" :options="chartOptions"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="singleQuestionModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="single_question_form" @submit.prevent="updateQuestionAnswer" class="w-100">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" v-if="singleQuestion === null">Processing... <i class="fa fa-fw fa-spin fa-spinner"></i></h1>
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" v-if="singleQuestion !== null"><strong>{{ singleQuestion.question }}</strong></h1>
                    </div>
                    <div class="modal-body">

                        <p v-if="singleQuestion === null" class="alert alert-info">Fetching Information. Please wait... <i class="fa fa-fw fa-spin fa-spinner"></i></p>
                        <div class="eachQuestions w-100 bg-white" v-if="singleQuestion !== null">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-xl-12 mt-3">

                                        <div class="w-100">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="list-unstyled px-2 px-lg-5">
                                                        <li v-if="singleQuestion.option_1.title !== null" :class="{'pointer-event-none': singleQuestionMitigation == null}">
                                                            <template v-if="singleQuestion.type === 'Regular'">
                                                                <p class="text-secondary m-0 p-0"><span v-html="singleQuestion.option_1.title"></span></p>
                                                            </template>
                                                            <template v-if="singleQuestion.type === 'Multiple_Answers'">
                                                                <p class="text-dark m-0 p-0"><strong v-html="singleQuestion.option_1.title"></strong></p>
                                                                <p class="text-secondary m-0 p-0"><span v-html="singleQuestion.option_1.desc"></span></p>
                                                            </template>
                                                            <div class="w-100 mt-2 custom-radio-checkbox">
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom"
                                                                           @change="no_risk_confirm_auto"
                                                                           :checked="singleQuestion.option_1.answer == '0'"
                                                                           :name="singleQuestion._id+'_q1'" type="radio" :id="'qCheck1Y'" value="0" required>
                                                                    <label class="form-check-label" :for="'qCheck1Y'">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom"
                                                                           @change="no_risk_confirm_auto"
                                                                           :checked="singleQuestion.option_1.answer == singleQuestion.option_1.risk_value"
                                                                           :name="singleQuestion._id+'_q1'" type="radio" :id="'qCheck1N'" :value="singleQuestion.option_1.risk_value" required>
                                                                    <label class="form-check-label"
                                                                           :for="'qCheck1N'">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ps-0">
                                                                    <input class="form-check-input-custom"
                                                                           @change="no_risk_confirm_auto"
                                                                           :checked="singleQuestion.option_1.answer == '-1'"
                                                                           :name="singleQuestion._id+'_q1'" type="radio" :id="'qCheck1NA'" value="-1" required>
                                                                    <label class="form-check-label" :for="'qCheck1NA'">NA</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <template v-if="singleQuestion.type === 'Multiple_Answers'">
                                                            <li class="mt-5" v-if="singleQuestion.option_2.title !== null" :class="{'pointer-event-none': singleQuestionMitigation == null}">
                                                                <p class="text-dark m-0 p-0"><strong v-html="singleQuestion.option_2.title"></strong></p>
                                                                <p class="text-secondary m-0 p-0"><span v-html="singleQuestion.option_2.desc"></span></p>
                                                                <div class="w-100 mt-2 custom-radio-checkbox">
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_2.answer == '0'"
                                                                               :name="singleQuestion._id+'_q2'" type="radio" :id="'qCheck2Y'" value="0" required>
                                                                        <label class="form-check-label" :for="'qCheck2Y'">Yes</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_2.answer == singleQuestion.option_2.risk_value"
                                                                               :name="singleQuestion._id+'_q2'" type="radio" :id="'qCheck2N'" :value="singleQuestion.option_2.risk_value" required>
                                                                        <label class="form-check-label"
                                                                               :for="'qCheck2N'">No</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_2.answer == '-1'"
                                                                               :name="singleQuestion._id+'_q2'" type="radio" :id="'qCheck2NA'" value="-1" required>
                                                                        <label class="form-check-label" :for="'qCheck2NA'">NA</label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="mt-5" v-if="singleQuestion.option_3.title !== null" :class="{'pointer-event-none': singleQuestionMitigation == null}">
                                                                <p class="text-dark m-0 p-0"><strong v-html="singleQuestion.option_3.title"></strong></p>
                                                                <p class="text-secondary m-0 p-0"><span v-html="singleQuestion.option_3.desc"></span></p>
                                                                <div class="w-100 mt-2 custom-radio-checkbox">
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_3.answer == '0'"
                                                                               :name="singleQuestion._id+'_q3'" type="radio" :id="'qCheck3Y'" value="0" required>
                                                                        <label class="form-check-label" :for="'qCheck3Y'">Yes</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_3.answer == singleQuestion.option_3.risk_value"
                                                                               :name="singleQuestion._id+'_q3'" type="radio" :id="'qCheck3N'" :value="singleQuestion.option_3.risk_value" required>
                                                                        <label class="form-check-label"
                                                                               :for="'qCheck3N'">No</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_3.answer == '-1'"
                                                                               :name="singleQuestion._id+'_q3'" type="radio" :id="'qCheck3NA'" value="-1" required>
                                                                        <label class="form-check-label" :for="'qCheck3NA'">NA</label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="mt-5" v-if="singleQuestion.option_4.title !== null" :class="{'pointer-event-none': singleQuestionMitigation == null}">
                                                                <p class="text-dark m-0 p-0"><strong v-html="singleQuestion.option_4.title"></strong></p>
                                                                <p class="text-secondary m-0 p-0"><span v-html="singleQuestion.option_4.desc"></span></p>
                                                                <div class="w-100 mt-2 custom-radio-checkbox">
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_4.answer == '0'"
                                                                               :name="singleQuestion._id+'_q4'" type="radio" :id="'qCheck4Y'" value="0" required>
                                                                        <label class="form-check-label" :for="'qCheck4Y'">Yes</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_4.answer == singleQuestion.option_4.risk_value"
                                                                               :name="singleQuestion._id+'_q4'" type="radio" :id="'qCheck4N'" :value="singleQuestion.option_4.risk_value" required>
                                                                        <label class="form-check-label"
                                                                               :for="'qCheck4N'">No</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline ps-0">
                                                                        <input class="form-check-input-custom"
                                                                               @change="no_risk_confirm_auto"
                                                                               :checked="singleQuestion.option_4.answer == '-1'"
                                                                               :name="singleQuestion._id+'_q4'" type="radio" :id="'qCheck4NA'" value="-1" required>
                                                                        <label class="form-check-label" :for="'qCheck4NA'">NA</label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <template v-if="mitigationLoading === 1">
                        <div class="w-100 text-center">
                            <p class="alert alert-primary">Calculating Mitigation Strategies... <i class="fa fa-fw fa-spin fa-spinner"></i></p>
                        </div>
                    </template>
                    <template v-if="mitigationLoading === 0">
                        <div class="modal-header border-top bg-light">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Risk Level & Mitigation Strategies</h1>
                        </div>
                        <div class="modal-body" v-if="mitigationLoading === 0">
                            <p v-if="singleQuestionMitigation == null" class="alert alert-primary">No Mitigation Strategies has been found.</p>
                            <div class="alert alert-warning" v-if="singleQuestionMitigation != null && singleQuestionRisk !== 'No'">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="no_risk_confirm" @change="no_risk_confirm">
                                    <label class="form-check-label" for="no_risk_confirm">
                                        <strong>I confirm that I have addressed the issues of the above questions</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="w-100 p-3" style="height: 350px;overflow: auto;" v-if="singleQuestionMitigation != null">
                                <h6 v-if="singleQuestionMitigation != null" v-html="singleQuestionMitigation.mitigation"></h6>
                            </div>
                        </div>
                    </template>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <div class="d-inline-block">
                            <input type="hidden" name="domain" :value="'domain_'+singleQuestionDomain">
                            <input type="hidden" name="evaluation_id" :value="evaluation_id">
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 me-2" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="d-inline-block">
                            <button type="button" class="btn btn-sm btn-warning rounded-pill px-3 me-2" @click="OpenThisQuestionChatGPT(singleQuestion)">Mitigation Strategy</button>
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Save Changes</button>
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
import {Chart as ChartJS, ArcElement, Tooltip, Legend} from 'chart.js'
import {Pie} from 'vue-chartjs'
import Swal from "sweetalert2";

ChartJS.register(ArcElement, Tooltip, Legend)

export default {
    data() {
        return {
            UserInfo: window.core.UserInfo,
            loading: 1,
            mitigationLoading: null,
            loadingStep: 0,
            progress: 0,
            evaluation_id: this.$route.params.evaluation_id,
            risk_evaluation: null,
            chart: null,
            chartOptions: null,
            singleQuestion: null,
            singleQuestionRisk: null,
            singleQuestionIndex: null,
            singleQuestionMitigation: null,
            singleQuestionDomain: null,
            singleQuestionModal: null,
            singleQuestionChatGPTModal: null,
            ReportGPT: null
        }
    },
    components: {Pie},
    watch: {},
    methods: {
        showLoading: function (step) {
            if (step <= 4) {
                this.progress = 0;
                this.loadingStep = step;
                setTimeout(() => {
                    this.progress = 30;
                    setTimeout(() => {
                        this.progress = 50;
                        setTimeout(() => {
                            this.progress = 75;
                            setTimeout(() => {
                                this.progress = 90;
                                setTimeout(() => {
                                    this.progress = 100;
                                    setTimeout(() => {
                                        this.showLoading(step + 1);
                                    }, 1000)
                                }, 1000)
                            }, 1000)
                        }, 1000)
                    }, 1000)
                }, 1000)
            }
        },
        is_last_even(idx) {
            const last = idx + 1;
            if (last === this.risk_evaluation.riskReport.sections.length) {
                if (idx % 2 === 0) {
                    return 'col-lg-12';
                } else {
                    return 'col-lg-6';
                }

            } else {
                return 'col-lg-6';
            }
        },
        pieClicked: function (event, section) {
            console.log(event, section);
        },
        evaluation_report: function () {
            const THIS = this;
            THIS.loading = 1;
            THIS.risk_evaluation = null;
            THIS.ReportGPT = null;
            ApiService.POST(ApiRoutes.user_evaluation_report, {evaluation_id: THIS.evaluation_id}, function (res) {
                THIS.loading = 0;
                if (res.status === 200) {
                    THIS.risk_evaluation = res.risk_evaluation;
                    THIS.ReportGPT = res.risk_evaluation.riskReport.chatGPT;

                    // The Pie Chart
                    THIS.chart = {
                        labels: [
                            'Low (' + res.risk_evaluation.riskReport.riskPercentage.Low + '%)',
                            'Limited (' + res.risk_evaluation.riskReport.riskPercentage.Limited + '%)',
                            'High (' + res.risk_evaluation.riskReport.riskPercentage.High + '%)',
                            'No (' + res.risk_evaluation.riskReport.riskPercentage.No + '%)'
                        ],
                        datasets: [
                            {
                                backgroundColor: ['#44BD32', '#778CA3', '#EB3B5A', '#ffffff'],
                                borderColor: ['#44BD32', '#778CA3', '#EB3B5A', '#e6e6e6'],
                                borderWidth: [5, 5, 5, 5],
                                data: [
                                    res.risk_evaluation.riskReport.riskPercentage.Low,
                                    res.risk_evaluation.riskReport.riskPercentage.Limited,
                                    res.risk_evaluation.riskReport.riskPercentage.High,
                                    res.risk_evaluation.riskReport.riskPercentage.No
                                ]
                            }
                        ],
                    };
                    THIS.chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            position: 'bottom',
                            display: true,
                            text: 'Risk Evaluation'
                        },
                        onClick: THIS.pieClicked
                    }
                    console.log(THIS.chart);
                }
            })
        },
        OpenThisQuestion: function (domain, index, risk_level, section = null) {
            const THIS = this;
            THIS.singleQuestionRisk = risk_level;
            THIS.mitigationLoading = null;
            THIS.singleQuestionMitigation = null;
            if (domain === 'eta' || domain === 'nt' || domain === 'fd' || domain === 'eta-fd') {
                THIS.singleQuestionDomain = domain;
            } else {
                THIS.singleQuestionDomain = domain.uid;
            }

            let param = {
                group: THIS.singleQuestionDomain,
                q_index: index,
                evaluation_id: this.evaluation_id,
            }
            if (domain === 'eta-fd') {
                param['fd_index'] = 'domain_' + section.parent_id + '_' + section.uid
            }

            THIS.singleQuestion = null;
            THIS.singleQuestionIndex = index;
            THIS.openSingleQuestion();
            ApiService.POST(ApiRoutes.user_evaluation_question_single, param, function (res) {
                if (res.status === 200) {
                    THIS.singleQuestion = res.data;
                }
            })
        },
        OpenThisQuestionChatGPT: function (singleQuestion) {
            if (this.UserInfo.subscription_type === 'free') {
                Swal.fire({
                    title: 'Premium Module',
                    text: "You must subscribe to premium plan to have all premium features.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0d9f56',
                    cancelButtonColor: '#777777',
                    confirmButtonText: 'Go to Pricing',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/pricing';
                    }
                });
            } else {
                const THIS = this;
                const param = {
                    _id: singleQuestion._id,
                    evaluation_id: this.evaluation_id,
                    q_index: this.singleQuestionIndex,
                    risk: this.singleQuestionRisk,
                }
                if (singleQuestion.category === 'eta-fd') {
                    param['fd_index'] = 'domain_' + singleQuestion.sector + '_' + singleQuestion.sub_sector
                }
                THIS.mitigationLoading = 1;
                ApiService.POST(ApiRoutes.user_evaluation_question_single_chatGPT, param, function (res) {
                    THIS.mitigationLoading = 0;
                    if (res.status === 200) {
                        THIS.singleQuestion = res.data;
                        THIS.singleQuestionMitigation = res.data.mitigation;
                    }
                })
            }
        },
        updateQuestionAnswer: function () {
            const THIS = this;
            const object = {};
            const formData = new FormData(document.getElementById('single_question_form'));
            formData.forEach(function (value, key) {
                object[key] = value;
            });
            let domain = '';
            if (THIS.singleQuestionDomain === 'nt') {
                domain = 'nt';
            } else if (THIS.singleQuestionDomain === 'fd') {
                domain = 'fd';
            } else if (THIS.singleQuestionDomain === 'eta-fd') {
                domain = 'eta-fd';
            } else {
                domain = 'domain_' + THIS.singleQuestionDomain;
            }
            const param = {
                answers: object,
                domain: domain,
                evaluation_id: THIS.evaluation_id
            }
            if (this.singleQuestion.category === 'eta-fd') {
                param['fd_index'] = 'domain_' + this.singleQuestion.sector + '_' + this.singleQuestion.sub_sector
            }
            ApiService.POST(ApiRoutes.user_evaluation_question_single_update, param, function (res) {
                if (res.status === 200) {
                    THIS.closeSingleQuestion();
                    THIS.showLoading(1);
                    THIS.evaluation_report();
                }
            })
        },
        openSingleQuestion: function () {
            this.singleQuestionModal = new bootstrap.Modal(document.getElementById('singleQuestionModal'));
            this.singleQuestionModal.show();
        },
        closeSingleQuestion: function () {
            this.singleQuestionModal.hide();
        },
        no_risk_confirm: function () {
            const no_risk_confirm = document.getElementById('no_risk_confirm');
            if (no_risk_confirm.checked) {
                if (this.singleQuestion.option_1.answer !== undefined) {
                    this.singleQuestion.option_1.answer = '0';
                }
                if (this.singleQuestion.option_2.answer !== undefined) {
                    this.singleQuestion.option_2.answer = '0';
                }
                if (this.singleQuestion.option_3.answer !== undefined) {
                    this.singleQuestion.option_3.answer = '0';
                }
                if (this.singleQuestion.option_4.answer !== undefined) {
                    this.singleQuestion.option_4.answer = '0';
                }
            } else {
                if (this.singleQuestion.option_1.answer !== undefined) {
                    this.singleQuestion.option_1.answer = this.singleQuestion.option_1.risk_value;
                }
                if (this.singleQuestion.option_2.answer !== undefined) {
                    this.singleQuestion.option_2.answer = this.singleQuestion.option_2.risk_value;
                }
                if (this.singleQuestion.option_3.answer !== undefined) {
                    this.singleQuestion.option_3.answer = this.singleQuestion.option_3.risk_value;
                }
                if (this.singleQuestion.option_4.answer !== undefined) {
                    this.singleQuestion.option_4.answer = this.singleQuestion.option_4.risk_value;
                }
            }
        },
        no_risk_confirm_auto: function () {
            let no_risk_confirm = document.getElementById('no_risk_confirm');
            let no_risk_check = 1;

            const q1 = $('[name="' + this.singleQuestion._id + '_q1"]:checked').val();
            const q2 = $('[name="' + this.singleQuestion._id + '_q2"]:checked').val();
            const q3 = $('[name="' + this.singleQuestion._id + '_q3"]:checked').val();
            const q4 = $('[name="' + this.singleQuestion._id + '_q4"]:checked').val();
            if (q1 !== undefined && parseInt(q1) > 0) {
                no_risk_check = 0;
            }
            if (q2 !== undefined && parseInt(q2) > 0) {
                no_risk_check = 0;
            }
            if (q3 !== undefined && parseInt(q3) > 0) {
                no_risk_check = 0;
            }
            if (q4 !== undefined && parseInt(q4) > 0) {
                no_risk_check = 0;
            }
            if (no_risk_confirm != null) {
                if (no_risk_check === 1) {
                    no_risk_confirm.checked = true;
                } else {
                    no_risk_confirm.checked = false;
                }
            }
        },
        certificateUrl: function () {
            return ApiRoutes.user_evaluation_certificate + '/' + this.risk_evaluation.evaluation._id;
        }
    },
    created() {
        this.evaluation_report();
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>
