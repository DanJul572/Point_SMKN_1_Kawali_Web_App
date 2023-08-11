<template>
<div>
    <div class="card shadow mb-2">
        <div class="card-body">
            <ValidationObserver v-slot="{ handleSubmit }">
            <form method="post" v-on:submit.prevent="handleSubmit(lists)">
                <div class="row">
                    <div class="col-md-5">
                        <ValidationProvider rules="required" v-slot="{ errors }">
                            <small>Tingkat :</small>
                            <select v-model="form_filter.tingkat_id" :class="classInput(errors[0])">
                                <option v-for="hasil in tingkat" :key="hasil.id" :value="hasil.id">{{ hasil.nama }}</option>
                            </select>
                            <small class="invalid-feedback">
                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                            </small>
                        </ValidationProvider>
                    </div>
                    <div class="col-md-5">
                        <ValidationProvider rules="required" v-slot="{ errors }">
                            <small>Kelas :</small>
                            <select v-model="form_filter.kelas_id" :class="classInput(errors[0])">
                                <option v-for="hasil in kelas" :key="hasil.id" :value="hasil.id">{{ hasil.nama }}</option>
                            </select>
                            <small class="invalid-feedback">
                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                            </small>
                        </ValidationProvider>
                    </div>
                    <div class="col">
                        <small>Aksi :</small>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-fw fa-filter"></i> Ambil Data
                        </button>
                    </div>
                </div>
            </form>
            </ValidationObserver>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header">
            Poin Siswa
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col text-right">
                    <button v-on:click="showModalLaporan('umum')" class="btn btn-sm btn-success">
                        <i class="fas fa-fw fa-clipboard"></i> Tampilkan Laporan Umum
                    </button>
                    <button v-on:click="showModalLaporan('spesifik')" class="btn btn-sm btn-success">
                        <i class="fas fa-fw fa-clipboard"></i> Tampilkan Laporan Spesifik
                    </button>
                    <a :href="create_route" class="btn btn-sm btn-primary">
                        <i class="fas fa-fw fa-plus-square"></i> Tambah Poin Siswa
                    </a>
                </div>
            </div>
            <vue-good-table
            :columns="columns"
            :rows="rows"
            :sort-options="{enabled: false}"
            :search-options="{enabled: true, trigger: 'enter'}"
            :pagination-options="{enabled: true}">
                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'aksi'">
                        <div class="d-flex">
                            <button v-on:click="infoUmum(props.row.id)" class="btn btn-info btn-xs mr-1">
                                <i class="fas fa-fw fa-globe"></i>
                            </button>
                            <button v-on:click="infoSpesifik(props.row.id)" class="btn btn-info btn-xs mr-1">
                                <i class="fas fa-fw fa-list-ul"></i>
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
    <!-- Modal Laporan Umum -->
    <div class="modal fade" id="laporanModalUmum" tabindex="-1" role="dialog" aria-labelledby="laporanModalUmumLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myModalLabel">Laporan Umum Poin Siswa</h6>
                    <button v-on:click="hideModalLaporan('umum')" type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <vue-excel-editor v-if="rows.length > 0" v-model="rows" ref="grid" readonly>
                        <vue-excel-column field="nama" label="Nama" width="200px"/>
                        <vue-excel-column field="kelas" label="Kelas" width="150px"/>
                        <vue-excel-column field="nis" label="NIS" width="150px"/>
                        <vue-excel-column field="perolehan_poin" label="Perolehan Poin" width="150px"/>
                        <vue-excel-column field="total_penebusan" label="Total Penebusan" width="150px"/>
                        <vue-excel-column field="total_poin" label="Total Poin" width="150px"/>
                        <vue-excel-column field="sanksi" label="Sanksi" width="200px"/>
                    </vue-excel-editor>
                    <div v-else class="alert alert-info text-left">Laporan Tidak Tersedia</div>
                </div>
                <div class="modal-footer">
                    <button v-on:click="hideModalLaporan('umum')" type="button" class="btn btn-sm btn-secondary">
                        <i class="fas fa-fw fa-times-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Laporan Spesifik -->
    <div class="modal fade" id="laporanModalSpesifik" tabindex="-1" role="dialog" aria-labelledby="laporanModalSpesifikLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myModalLabel">Laporan Spesifik Poin Siswa</h6>
                    <button v-on:click="hideModalLaporan('spesifik')" type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <vue-excel-editor v-if="spesifik_rows.length > 0" v-model="spesifik_rows" ref="grid" readonly>
                        <vue-excel-column field="nama" label="Nama" width="200px"/>
                        <vue-excel-column field="nis" label="NIS" width="150px"/>
                        <vue-excel-column field="kelas" label="Kelas" width="100px"/>
                        <vue-excel-column field="kode_poin" label="Kode Poin" width="100px"/>
                        <vue-excel-column field="nilai_poin" label="Nilai Poin" width="100px"/>
                        <vue-excel-column field="frekuensi" label="Frekuensi" width="100px"/>
                        <vue-excel-column field="total_poin" label="Total Poin" width="100px"/>
                        <vue-excel-column field="deskripsi_poin" label="Deskripsi Poin" width="200px"/>
                    </vue-excel-editor>
                    <div v-else class="alert alert-info text-left">Laporan Tidak Tersedia</div>
                </div>
                <div class="modal-footer">
                    <button v-on:click="hideModalLaporan('spesifik')" type="button" class="btn btn-sm btn-secondary">
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
            columns: [
                {field: 'nama', label: 'Nama'},
                {field: 'nis', label: 'NIS'},
                {field: 'kelas', label: 'Kelas'},
                {field: 'total_poin', label: 'Total Poin'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
            tingkat: [],
            kelas: [],
            spesifik_rows: [],
            tipe_laporan: '',
            form_filter: {
                tingkat_id: '',
                kelas_id: ''
            },
        }
    },
    props: [
        'create_route'
    ],
    mounted () {
        this.formData();
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.post('/siswa/poin', this.form_filter)
            .then(response => {
                this.rows = [];
                this.spesifik_rows = [];
                if (response.data.length == 0) {
                    loader.hide();
                    this.$toastr.info('Data <b>Poin Siswa</b> kosong.');
                } else {
                    this.mappingData(response.data);
                    loader.hide();
                    this.$toastr.success('Pengambilan data <b>Poin Siswa</b> berhasil.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async formData () {
            let loader = this.$loading.show();
            await axios.get('/siswa/form')
            .then(response => {
                this.tingkat = response.data.tingkat;
                this.kelas = response.data.kelas;
                loader.hide();
                this.$toastr.success('Pemganbilan <b>Data Form</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        infoSpesifik(id) {
            let poin = this.spesifik_rows.filter(x => x.id == id);
            let array = [];
            poin.forEach(item => {
                array.push(`<div class="col-6 mb-3">
                                <div class="row mb-2">
                                    <div class="col"><small>Kode Poin</small></div>
                                    <div class="col"><small>:</small></div>
                                    <div class="col text-right"><small>` + item.kode_poin + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><small>Nilai Poin</small></div>
                                    <div class="col"><small>:</small></div>
                                    <div class="col text-right"><small>` + item.nilai_poin + ` poin</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><small>Frekuensi</small></div>
                                    <div class="col"><small>:</small></div>
                                    <div class="col text-right"><small>` + item.frekuensi + ` x</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><small>Total Poin</small></div>
                                    <div class="col"><small>:</small></div>
                                    <div class="col text-right"><small>` + (item.nilai_poin * item.frekuensi) + ` poin</small></div>
                                </div>
                                <div class="row">
                                    <div class="col"><small>` + item.deskripsi_poin + `</small></div>
                                </div>
                            </div>`);
            });
            this.$swal({
                html: `<div class="row text-left">` + array.join('') + `</div>`,
                width: '80%'
            });
        },
        infoUmum (id) {
            let siswa = this.rows.find(x => x.id == id);
            let html = `<div class="row text-left">
                            <div class="col">
                                <div class="row mb-2">
                                    <div class="col-3"><small>Nama</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + siswa.nama + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>NIS</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + siswa.nis + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kelas</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + siswa.kelas + `</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Poin Diperoleh</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + (siswa.total_poin + siswa.total_penebusan) + ` poin</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Total Penebusan</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + siswa.total_penebusan + ` poin</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Total Poin</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + siswa.total_poin + ` poin</small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Sanksi</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col text-right"><small>` + siswa.sanksi + `</small></div>
                                </div>
                            </div>
                        </div>`
            this.$swal({
                html: html,
                width: '60%'
            });
        },
        mappingData (data) {
            data.forEach(item => {
                let sanksi = '';
                if (item.sanksi === null) {
                    sanksi = 'Belum ada sanksi';
                } else {
                    sanksi = item.sanksi.keterangan;
                }
                this.rows.push({
                    id: item.id,
                    nama: item.nama,
                    nis: item.nis,
                    kelas: item.tingkat.nama + '-' + item.kelas.nama,
                    perolehan_poin: item.total_poin + item.total_penebusan,
                    total_penebusan: item.total_penebusan,
                    total_poin: item.total_poin,
                    sanksi: sanksi,
                });
                item.poin.forEach(element => {
                    let poin = this.spesifik_rows.find(x => (x.poin_id == element.id) && (x.id == item.id));
                    if (poin) {
                        poin.frekuensi += 1;
                        poin.total_poin = poin.frekuensi * element.nilai;
                    } else {
                        this.spesifik_rows.push({
                            id: item.id,
                            poin_id: element.id,
                            nama: item.nama,
                            nis: item.nis,
                            kelas: item.tingkat.nama + '-' + item.kelas.nama,
                            kode_poin: element.kode,
                            deskripsi_poin: element.deskripsi,
                            nilai_poin: element.nilai,
                            frekuensi: 1,
                            total_poin: 1 * element.nilai,
                        });
                    }
                });
            });
        },
        classInput(error) {
            if (error) {
                return 'form-control is-invalid';
            } else {
                return 'form-control';
            }
        },
        showModalLaporan(type) {
            if (type == 'umum') {
                $('#laporanModalUmum').modal('show');
            } else {
                $('#laporanModalSpesifik').modal('show');
            }
        },
        hideModalLaporan(type) {
            if (type == 'umum') {
                $('#laporanModalUmum').modal('hide');
            } else {
                $('#laporanModalSpesifik').modal('hide');
            }
        },
    },
}
</script>
