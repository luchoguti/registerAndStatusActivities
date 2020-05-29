<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3>Jobs Lists </h3></div>
                        <div class="float-right">
                            <div class="btn-group">
                                <a href="/create" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="mytable" class="table table-bordred table-striped" data-form="ListaForm">
                            <thead>
                            <th>Details Activities</th>
                            <th>Status</th>
                            <th>Date Execute</th>
                            <th>Days Delays</th>
                            <th>Employees</th>
                            </thead>
                            <tbody>
                                <tr v-for="dataRows in dataActivities">
                                    <td>{{ dataRows.name }}</td>
                                    <td>{{ dataRows.status }}</td>
                                    <td>{{ dataRows.date_execute }}</td>
                                    <td>{{ dataRows.days_delay }}</td>
                                    <td>{{ dataRows.foreign_key_employees[0].first_name }} {{ dataRows.foreign_key_employees[0].second_name }}</td>
                                    <td>
                                        <router-link :to="{name: 'create', params: { id: dataRows.id_activities }}" class="btn btn-primary"><span class="fa fa-pencil"></span></router-link>
                                    </td>
                                    <td>
                                        <button @click.prevent="confirmRemove(dataRows.id_activities,dataRows.name)" class="btn btn-danger btn-xs" type="button"><span class="fa fa-trash"></span></button>
                                    </td>
                                </tr>
                                <tr v-if="dataActivities.length == 0">
                                    <td colspan="7">There are not activities registration!!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                dataActivities:[]
            }
        },
        created() {
            var app = this;
            let loader = this.loading();
            let uri = 'https://webhookprueb.herokuapp.com/api/activities';
            this.axios.get(uri).then(response => {
                this.dataActivities = response.data;
                loader.hide();
            });
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
            confirmRemove(id,nameActivity){
                let element = this;
                this.$dialog.confirm('Esta seguro de eliminar la actividad '+nameActivity+'?',{
                    loader: true
                })
                    .then((dialog) => {
                        setTimeout(() => {
                            element.removeHotel(id);
                            dialog.close();
                        }, 2500);

                    })
                    .catch(() => {
                        console.log('Delete aborted');
                    });
            },
            removeHotel(id){
                let loader = this.loading();
                let uri_delete = `https://webhookprueb.herokuapp.com/api/activities/${id}`;
                this.axios.delete(uri_delete).then(response => {
                    this.dataActivities.splice(this.dataActivities.indexOf(id), 1);
                    loader.hide();
                });
            }
        }
    }
</script>
