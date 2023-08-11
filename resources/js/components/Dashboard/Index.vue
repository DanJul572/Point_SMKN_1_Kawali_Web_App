<template>
    <div>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-fw fa-chalkboard-teacher text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Guru</p>
                                    <h4 class="card-title">{{ data.count_guru }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-fw fa-user-graduate text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Siswa</p>
                                    <h4 class="card-title">{{ data.count_siswa }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-fw fa-comments text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Pengaduan</p>
                                    <h4 class="card-title">{{ data.count_pengaduan }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="far fa-fw fa-calendar-check text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Semester {{ data.semester }}</p>
                                    <h4 class="card-title">{{ data.tahun_ajaran }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Poin Tertinggi</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <vue-good-table
                            :columns="columns"
                            :rows="rows"
                            :sort-options="{enabled: false}"
                            :search-options="{enabled: true, trigger: 'enter'}"
                            :pagination-options="{enabled: true}">
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            data: '',
            columns: [
                {field: 'nama', label: 'Nama'},
                {field: 'nis', label: 'NIS'},
                {field: 'kelas', label: 'Kelas'},
                {field: 'total_poin', label: 'Total Poin'},
            ],
            rows: [],
        }
    },
    mounted () {
        this.getData();
    },
    methods: {
        async getData () {
            let loader = this.$loading.show();
            await axios.get('/dashboard/data')
            .then(response => {
                this.data = response.data.card;
                this.rows = response.data.table;
                loader.hide();
                this.$toastr.success('Pengambilan data berhasil.');
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Data : ' + error.message);
            });
        }
    }
}
</script>
