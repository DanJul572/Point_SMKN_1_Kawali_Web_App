<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Pegaduan
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col text-right">
                        <button v-on:click="showLaporanModal" class="btn btn-sm btn-success">
                            <i class="fas fa-fw fa-clipboard"></i> Tampilkan Laporan
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :sort-options="{enabled: false}"
                        :search-options="{enabled: true, trigger: 'enter'}"
                        :pagination-options="{enabled: true}">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'status'">
                               <div v-if="props.row.status == 0" class="badge badge-danger">Belum Dikonfirmasi</div>
                               <div v-else class="badge badge-success">Sudah Dikonfirmasi</div>
                            </span>
                            <span v-else-if="props.column.field == 'aksi'">
                                <button v-if="props.row.status == 0" v-on:click="confirmUbahStatus(props.row.id)" class="btn btn-success btn-xs">
                                   <i class="fas fa-fw fa-check"></i>
                                </button>
                                <button v-on:click="confirmDestroy(props.row.id)" class="btn btn-danger btn-xs">
                                   <i class="fas fa-fw fa-trash"></i>
                                </button>
                                <button v-on:click="info(props.row.id)" class="btn btn-info btn-xs">
                                   <i class="fas fa-fw fa-info"></i>
                                </button>
                                <button v-on:click="showImageModal(props.row.id)" class="btn btn-info btn-xs">
                                   <i class="fas fa-fw fa-camera"></i>
                                </button>
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>
                        </vue-good-table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Laporan -->
        <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="laporanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="myModalLabel">Laporan Daftar Pengaduan</h6>
                        <button v-on:click="hideLaporanModal" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <vue-excel-editor v-model="rows" ref="grid" readonly>
                            <vue-excel-column field="yang_mengadu" label="Yang Mengadu" width="200px" />
                            <vue-excel-column field="yang_diadukan" label="Yang Diadukan" width="200px" />
                            <vue-excel-column field="nis" label="NIS" width="150px" />
                            <vue-excel-column field="kelas" label="Kelas" width="100px" />
                            <vue-excel-column field="kode_poin" label="Kode Poin" width="100px" />
                            <vue-excel-column field="deskripsi_poin" label="Deskripsi Poin" width="200px" />
                            <vue-excel-column field="tanggal" label="Tanggal" width="150px" />
                            <vue-excel-column field="string_status" label="Status" width="150px" />
                        </vue-excel-editor>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="hideLaporanModal" type="button" class="btn btn-sm btn-secondary">
                            <i class="fas fa-fw fa-times-circle"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Gambar -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="imageModalTitle">Bukti Pengaduan</h6>
                        <button v-on:click="hideImageModal" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body text-center">
                    <img v-if="gambar" :src="asset_url + '/' + gambar">
                </div>
                    <div class="modal-footer">
                        <button v-on:click="hideImageModal" type="button" class="btn btn-sm btn-secondary">
                            <i class="fas fa-fw fa-times-circle"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    props: [
        'asset_url'
    ],
    data () {
        return {
            columns: [
                {field: 'yang_mengadu', label: 'Yang Mengadu'},
                {field: 'yang_diadukan', label: 'Yang Diadukan'},
                {field: 'kode_poin', label: 'Kode Poin'},
                {field: 'status', label: 'Status'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
            gambar: '',
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.get('/pengaduan/lists')
            .then(response => {
                this.mappingData(response.data);
                loader.hide();
                this.$toastr.success('Pengambilan data <b>Pengaduan</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async ubahStatus (id) {
            let loader = this.$loading.show();
            await axios.get('/pengaduan/konfirmasi/' + id)
            .then(response => {
                let index = this.rows.findIndex(x => x.id == id);
                this.rows[index].status = 1;
                this.rows[index].string_status = 'Sudah Dikonfirmasi';
                loader.hide();
                this.$toastr.success('<b>Pengaduan</b> berhasil dikonfirmasi.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Konfirmasi : ' + error.message);
            });
        },
        async destroy (id) {
            let loader = this.$loading.show();
            await axios.get('/pengaduan/destroy/' + id)
            .then(response => {
                let index = this.rows.findIndex(x => x.id == id);
                this.rows.splice(index, 1);
                loader.hide();
                this.$toastr.success('<b>Pengaduan</b> berhasil dihapus.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Hapus : ' + error.message);
            });
        },
        info (id) {
            let pengaduan = this.rows.find(x => x.id == id);
            let html = `<div class="row text-left">
                            <div class="col">
                                <div class="row mb-2">
                                    <div class="col-3"><small>Yang Mengadu</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.yang_mengadu + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Yang Diadukan</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.yang_diadukan + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>NIS</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.nis + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kelas</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.kelas + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kode Poin</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.kode_poin + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Deskripsi Poin</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.deskripsi_poin + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Tanggal</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.tanggal + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Status</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + pengaduan.string_status + `</small></div>
                                </div>
                            </div>
                        </div>`
            this.$swal({
                html: html,
                width: '60%'
            });
        },
        confirmUbahStatus (id) {
            this.$swal({
                title: 'Apakah anda yakin ?',
                text: 'Pengaduan akan dikonfirmasi.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Konfirmasi'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.ubahStatus(id);
                }
            });
        },
        confirmDestroy (id) {
            this.$swal({
                title: 'Apakah anda yakin ?',
                text: 'Data pengaduan akan dihapus.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.destroy(id);
                }
            });
        },
        mappingData (data) {
            data.forEach(item => {
                let string_status = '';
                if (item.status == 0) {
                    string_status = 'Belum Dikonfirmasi';
                } else {
                    string_status = 'Sudah Dikonfirmasi';
                }
                this.rows.push({
                    id: item.id,
                    yang_mengadu: item.user.nama,
                    yang_diadukan: item.siswa.nama,
                    nis: item.siswa.nis,
                    kelas: item.siswa.tingkat.nama + '-' + item.siswa.kelas.nama,
                    kode_poin: item.poin.kode,
                    deskripsi_poin: item.poin.deskripsi,
                    status: item.status,
                    gambar: item.gambar,
                    string_status: string_status,
                    tanggal: moment(item.created_at).format('D MMMM YYYY')
                });
            });
        },
        showImageModal(id) {
            $('#imageModal').modal('show');
            this.gambar = this.rows.find(x => x.id == id).gambar;
        },
        hideImageModal() {
            $('#imageModal').modal('hide');
            this.gambar = '';
        },
        showLaporanModal() {
            $('#laporanModal').modal('show');
        },
        hideLaporanModal() {
            $('#laporanModal').modal('hide');
        },
    }
}
</script>
