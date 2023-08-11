<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Aksi
                    </div>
                    <div class="card-body">
                        <button v-if="data.akses_user == true" v-on:click="confirmUbahAksesUser" class="btn text-left btn-block btn-sm mb-2 btn-primary">
                            <i class="fas fa-fw fa-user-slash"></i> Matikan Akses User
                        </button>
                        <button v-else v-on:click="confirmUbahAksesUser" class="btn text-left btn-block btn-sm mb-2 btn-primary">
                            <i class="fas fa-fw fa-user-check"></i> Hidupkan Akses User
                        </button>
                        <button v-on:click="confirmNaikanSemester" class="btn text-left btn-block btn-sm mb-2 btn-primary">
                            <i class="fas fa-fw fa-angle-double-up"></i> Naikan Semester
                        </button>
                        <button v-on:click="confirmBersihData('siswa')" class="btn text-left btn-block btn-sm btn-primary">
                            <i class="fas fa-fw fa-trash"></i> Bersihkan Siswa Yang Lulus
                        </button>
                        <button v-on:click="confirmBersihData('pengaduan')" class="btn text-left btn-block btn-sm btn-primary">
                            <i class="fas fa-fw fa-trash"></i> Bersihkan Pengaduan Yang Terkonfirmasi
                        </button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Laporan Poin & Penebusan
                    </div>
                    <div class="card-body">
                        <button v-on:click="setLaporan('poin')" class="btn text-left btn-block btn-sm btn-primary">
                            <i class="fas fa-fw fa-exclamation-triangle"></i> Laporan Poin
                        </button>
                        <button v-on:click="setLaporan('penebusan')" class="btn text-left btn-block btn-sm btn-primary">
                            <i class="fas fa-fw fa-broom"></i> Laporan Penebusan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Laporan Spesifik -->
        <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="laporanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="myModalLabel">{{ title }}</h6>
                        <button v-on:click="hideModalLaporan" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <vue-excel-editor v-if="tbody.length > 0" v-model="tbody" ref="grid" readonly>
                            <vue-excel-column v-for="head in thead" :key="head.field" :field="head.field" :label="head.label" :width="head.width"/>
                        </vue-excel-editor>
                        <div v-else class="alert alert-info text-left">Laporan Tidak Tersedia</div>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="hideModalLaporan" type="button" class="btn btn-sm btn-secondary">
                            <i class="fas fa-fw fa-times-circle"></i> Tutup
                        </button>
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
            title: '',
            thead: [],
            tbody: [],
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.get('/operasi/lists')
            .then(response => {
                this.data = response.data;
                loader.hide();
                this.$toastr.success('Pengambilan data <b>Operasi</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async ubahAksesUser () {
            let loader = this.$loading.show();
            await axios.get('/operasi/ubah-akses-user')
            .then(response => {
                loader.hide();
                this.data.akses_user = response.data.status;
                this.$toastr.success('Akses <b>User</b> berhasil diubah.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Ubah Akses User : ' + error.message);
            });
        },
        async naikanSemester () {
            let loader = this.$loading.show();
            await axios.get('/operasi/naikan-semester')
            .then(response => {
                this.data.akses_user = response.data.status;
                loader.hide();
                this.$toastr.success('<b>Semester</b> berhasil dinaikan.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Naikan Semester : ' + error.message);
            });
        },
        async getLaporan(type, value) {
            let loader = this.$loading.show();
            await axios.post('/operasi/get-laporan', {
                type: type,
                value: value
            })
            .then(response => {
                if (response.data.status == 'laporan kosong') {
                    loader.hide();
                    this.$toastr.info('<b>Laporan Kosong!</b> Silakan periksa kembali data yang diinput.');
                } else {
                    this.title = response.data.title;
                    this.thead = response.data.thead;
                    this.tbody = response.data.tbody;
                    loader.hide();
                    this.$toastr.success('Pengambilan laporan berhasil.');
                    this.showModalLaporan();
                }
            })
            .catch(error => {
                loader.hide();
                this.$toastr.danger('Get Laporan : ' + error.message);
            });
        },
        async bersihData (url) {
            let loader = this.$loading.show();
            await axios.get(url)
            .then(response => {
                loader.hide();
                let html = `
                    Terhapus : <b>` + response.data.terhapus + ` Data</b><br>
                    Tidak Terhapus : <b>` + response.data.tidak_terhapus + ` Data</b>
                `;
                this.$toastr.info(html);
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Bersih Data : ' + error.message);
            });
        },
        confirmUbahAksesUser () {
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Anda akan mengubah akses User.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ubah'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.ubahAksesUser();
                }
            });
        },
        confirmNaikanSemester () {
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Anda akan menaikan semester.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Naikan'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.naikanSemester();
                }
            });
        },
        confirmBersihData (type) {
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Semua data yang terkait akan dibersihkan.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Bersihkan'
            }).then(result => {
                if (result.isConfirmed == true) {
                    let url = '';
                    if (type == 'siswa') {
                        url = '/operasi/bersih-data-siswa';
                    } else {
                        url = '/operasi/bersih-data-pengaduan';
                    }
                    this.bersihData(url);
                }
            });
        },
        setLaporan (type) {
            this.$swal({
                title: 'Pengambilan Laporan',
                text: 'Masukan data sesuai keperluan.',
                input: 'text',
                inputPlaceholder: 'ID Semester / Tahun Ajaran.',
                showCancelButton: true,
                confirmButtonText: 'Ambil',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silahkan masukan kode!'
                    }
                }
            })
            .then(result => {
                if (result.isConfirmed == true) {
                    this.getLaporan(type, result.value);
                }
            });
        },
        showModalLaporan() {
            $('#laporanModal').modal('show');
        },
        hideModalLaporan() {
            this.title = '';
            this.thead = [];
            this.tbody = [];
            $('#laporanModal').modal('hide');
        },
    }
}
</script>
