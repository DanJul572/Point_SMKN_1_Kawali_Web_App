<template>
    <div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-fw fa-exclamation-triangle text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Total Poin</p>
                                    <h4 class="card-title">{{ data.total_poin }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-fw fa-notes-medical text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Total Penebusan</p>
                                    <h4 class="card-title">{{ data.total_penebusan }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-fw fa-user-slash text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div class="numbers">
                                    <p class="card-category">Total Pelanggaran</p>
                                    <h4 class="card-title">{{ data.total_pelanggaran }}</h4>
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
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'aksi'">
                                        <div class="d-flex">
                                            <button v-on:click="info(props.row.id)" class="btn btn-info btn-xs">
                                                <i class="fas fa-fw fa-info"></i>
                                            </button>
                                        </div>
                                    </span>
                                    <span v-else>
                                        {{ props.formattedRow[props.column.field] }}
                                    </span>
                                </template>
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
    props: ['user'],
    data () {
        return {
            data: '',
            columns: [
                {field: 'kode', label: 'Kode'},
                {field: 'nilai', label: 'Nilai'},
                {field: 'frekuensi', label: 'Frekuensi'},
                {field: 'total', label: 'Total'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
        }
    },
    mounted () {
        this.cekKode();
        this.getData();
    },
    methods: {
        async getData () {
            let loader = this.$loading.show();
            await axios.get('/user/data')
            .then(response => {
                this.data = response.data.card;
                this.mappingData(response.data.table);
                loader.hide();
                this.$toastr.success('Pengambilan data berhasil.');
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Data : ' + error.message);
            });
        },
        async ubahKode () {
            let loader = this.$loading.show();
            await axios.post('/user/ubah-kode', this.user)
            .then(response => {
                loader.hide();
                this.$toastr.success('Kode anda berhasil diubah.');
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Ubah Kode : ' + error.message);
            });
        },
        mappingData (data) {
            data.forEach(item => {
                let poin = this.rows.find(x => (x.id == item.id));
                if (poin) {
                    poin.frekuensi += 1;
                    poin.total_poin = poin.frekuensi * item.nilai;
                } else {
                    this.rows.push({
                        id: item.id,
                        kode: item.kode,
                        deskripsi: item.deskripsi,
                        nilai: item.nilai,
                        frekuensi: 1,
                        total: 1 * item.nilai,
                    });
                }
            });
        },
        info (id) {
            let poin = this.rows.find(x => x.id == id);
            let html = `<div class="row text-left">
                            <div class="col">
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kode Poin</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + poin.kode + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Nilai Poin</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + poin.nilai + ` poin</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Frekuensi</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + poin.frekuensi + ` x</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Total Poin</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + poin.total + ` poin</small></div>
                                </div>
                                <div class="row">
                                    <div class="col"><small>` + poin.deskripsi + `</small></div>
                                </div>
                            </div>
                        </div>`
            this.$swal({
                html: html,
                width: '50%'
            });
        },
        cekKode () {
            if (this.user.kode == 'kodesaya') {
                this.$swal({
                    title: 'Ubah Kode Anda!',
                    text: 'Agar akun Anda aman, silahkan masukan kode baru.',
                    input: 'text',
                    inputValue: this.user.kode,
                    inputPlaceholder: 'Masukan Kode Baru Anda.',
                    confirmButtonText: 'Konfirmasi',
                    allowOutsideClick: false,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Silahkan masukan kode!'
                        }
                    }
                })
                .then(result => {
                    if (result.isConfirmed == true) {
                        this.user.kode = result.value;
                        this.ubahKode();
                    }
                });
            }
        },
    }
}
</script>
