<template>
    <v-app>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-danger alert-dismissible fade show" v-if="errors.length" v-for="error in errors" role="alert">
                        {{error}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" v-if="msgResponseAction.length" v-for="msgResponseAction in msgResponseAction" role="alert">
                        {{msgResponseAction}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left" v-if="typeof this.paramId === 'undefined' "><h3>New Activity</h3></div>
                            <div class="float-left" v-if="typeof this.paramId !== 'undefined' "><h3>Update Activity</h3></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="requestActivities">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Detail Activity:</label>
                                        <input type="text" v-model="activity.name" class="form-control input-sm" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Status Activities:</label>
                                        <select  class="custom-select input-sm" id="status" v-model="activity.status">
                                            <option value="">Selected Status</option>
                                            <option v-for="(index,item) in itemsStatusActivities" :value="item"> {{ index }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <v-menu
                                            v-model="fromDateMenu"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="290px"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-text-field
                                                    label="Date Execute"
                                                    prepend-icon="event"
                                                    readonly
                                                    :value="fromDateDisp"
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                locale="en-in"
                                                v-model="fromDateVal"
                                                no-title
                                                @input="fromDateMenu = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Employees:</label>
                                        <select  class="custom-select input-sm" id="employees" v-model="activity.employees">
                                            <option value="">Selected Employees</option>
                                            <option v-for="items in itemsEmployees" :value="items.id_employees"> {{ items.first_name }} {{ items.second_name }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" v-if="typeof this.paramId === 'undefined' " class="btn btn-success btn-block">Guardar</button>
                                    <button type="submit" v-if="typeof this.paramId !== 'undefined' " class="btn btn-success btn-block">Actualizar</button>
                                    <a href="/" class="btn btn-info btn-block">Atrás</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </v-app>
</template>
<script>
    import moment from 'moment';
    export default {
        data(){
            return {
                activity:{},
                itemsStatusActivities:[],
                itemsEmployees:[],
                labels: [],
                errors: [],
                msgResponseAction:[],
                msg:[],
                paramId:'',
                fromDateMenu: false,
                fromDateVal: null
            }
        },
        computed: {
            fromDateDisp() {
                return this.fromDateVal;
                // format date, apply validations, etc. Example below.
                // return this.fromDateVal ? this.formatDate(this.fromDateVal) : "";
            }
        },
        created() {
            let loader = this.loading();
            this.activity.status = '';
            let uri = 'http://127.0.0.1:8000/api/statusActivities';
            this.axios.get(uri).then(async response => {
                this.itemsStatusActivities = await response.data;
            });
            let uriEmployees = 'http://127.0.0.1:8000/api/employees';
            this.axios.get(uriEmployees).then(async response => {
                this.itemsEmployees = await response.data;
            });
            this.paramId=this.$route.params.id;
            if (typeof this.paramId !== "undefined") {
                let uriParam = `http://127.0.0.1:8000/api/activities/${this.paramId}`;
                this.axios.get(uriParam).then(async (response) => {
                    let objResp= await response.data;
                    this.activity.name = objResp[0].name;
                    this.activity.status = objResp[0].status_id;
                    this.fromDateVal =  moment(objResp[0].date_execute).format('YYYY-MM-DD');
                    this.activity.employees = objResp[0].id_employees;
                });
            }
            loader.hide();
        },
        methods: {
            loading(){
                var app = this;
                let loader = app.$loading.show({
                    // Optional parameters
                    container: app.fullPage ? null : app.$refs.formContainer,
                    canCancel: false,
                    onCancel: app.onCancel,
                });
                return loader;
            },
            validateFormActivity(){
                this.errors = [];
                let $response = true;
                if (!this.activity.name) {
                    this.errors.push('Detail Activity is required.');
                    $response = false;
                }
                if (!this.activity.status) {
                    this.errors.push('Status Activities is required.');
                    $response = false;
                }
                if (!this.fromDateVal) {
                    this.errors.push('Date Execute is required.');
                    $response = false;
                }
                if (!this.activity.employees) {
                    this.errors.push('Employees is required.');
                    $response = false;
                }
                return $response;
            },
            requestActivities(){
                let validate = this.validateFormActivity();
                if(validate) {
                    if (typeof this.paramId !== "undefined") {
                        this.updateActivity();
                    } else {
                        this.addNewActivity();
                    }
                }else{
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            },
            updateActivity() {
                let loader = this.loading();
                let uri = `http://127.0.0.1:8000/api/activities/${this.paramId}`;
                this.activity.date_execute = this.fromDateVal;
                let dataPost = {activity_info_basic:this.activity};
                this.axios.put(uri, dataPost).then((response) => {
                    this.msgResponseAction.push(response.data.message);
                    setTimeout(() => {
                        loader.hide();
                        this.$router.push('/');
                    }, 2500);
                }).catch((error) => {
                    loader.hide();
                    this.errors = [];
                    let msg=Object.values(JSON.parse(error.response.data.message));
                    let errors = this.errors;
                    msg.forEach(function (dataMsg,key) {
                        errors.push(dataMsg);
                    });
                });
            },
            addNewActivity() {
                let loader = this.loading();
                let uri = `http://127.0.0.1:8000/api/activities`;
                this.activity.date_execute = this.fromDateVal;
                let dataPost = {activity_info_basic:this.activity};
                this.axios.post(uri, dataPost).then((response) => {
                    this.msgResponseAction.push(response.data.message);
                    setTimeout(() => {
                        loader.hide();
                        this.$router.push('/');
                    }, 2500);
                }).catch((error) => {
                    loader.hide();
                    this.errors = [];
                    let msg=Object.values(JSON.parse(error.response.data.message));
                    let errors = this.errors;
                    msg.forEach(function (dataMsg,key) {
                        errors.push(dataMsg);
                    });
                });
            }
        },
    }
</script>
