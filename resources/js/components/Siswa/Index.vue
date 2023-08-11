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
                Siswa
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-right">
                        <button v-on:click="showModalImport" class="btn btn-sm btn-success">
                            <i class="fas fa-fw fa-file-import"></i> Import Data
                        </button>
                        <button v-on:click="showModal('laporan')" class="btn btn-sm btn-success">
                            <i class="fas fa-fw fa-clipboard"></i> Tampilkan Laporan
                        </button>
                        <button v-on:click="[showModal('save'), cleanForm(), update_status = false]" class="btn btn-sm btn-primary">
                            <i class="fas fa-fw fa-plus-square"></i> Tamdah Data Siswa
                        </button>
                        <button v-on:click="confirmHapusBanyak" class="btn btn-sm btn-danger">
                            <i class="fas fa-fw fa-trash"></i> Hapus Semua
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <vue-good-table
                        ref="my-table"
                        :columns="columns"
                        :rows="rows"
                        :sort-options="{enabled: false}"
                        :search-options="{enabled: true, trigger: 'enter'}"
                        :pagination-options="{enabled: true}"
                        :select-options="{ enabled: true }">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'aksi'">
                                <div class="d-flex">
                                    <button v-on:click="edit(props.row.id)" class="btn btn-success btn-xs mr-1">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </button>
                                    <button v-on:click="confirmDestroy(props.row.id)" class="btn btn-danger btn-xs">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </div>
                            </span>
                            <span v-else-if="props.column.field == 'kode'">
                                <a v-on:click="setKode(props.row.id)" href="#">{{ props.row.kode }}</a>
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
        <!-- Modal -->
        <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="saveModalLabel">Form Data Siswa</h6>
                                <button v-on:click="hideModal('save')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Nama :</small>
                                        <input v-model="form.nama" type="text" :class="classInput(errors[0])">
                                        <small class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required|integer|length_9" v-slot="{ errors }">
                                        <small>NIS :</small>
                                        <input v-model="form.nis" type="text" :class="classInput(errors[0])">
                                        <small class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Tingkat :</small>
                                        <select v-model="form.tingkat_id" :class="classInput(errors[0])">
                                            <option v-for="hasil in tingkat" :key="hasil.id" :value="hasil.id">{{ hasil.nama }}</option>
                                        </select>
                                        <small class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Kelas :</small>
                                        <select v-model="form.kelas_id" :class="classInput(errors[0])">
                                            <option v-for="hasil in kelas" :key="hasil.id" :value="hasil.id">{{ hasil.nama }}</option>
                                        </select>
                                        <small class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button v-on:click="hideModal('save')" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-fw fa-times-circle"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-fw fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <!-- Modal Laporan -->
        <div class="modal fade" id="laporanModal" tabindex="-1" role="dialog" aria-labelledby="laporanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="myModalLabel">Laporan Daftar Siswa</h6>
                        <button v-on:click="hideModal('laporan')" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <vue-excel-editor v-model="rows" ref="grid" readonly>
                            <vue-excel-column field="nama" label="Nama" width="300px"/>
                            <vue-excel-column field="nis" label="NIS" width="250px"/>
                            <vue-excel-column field="kelas" label="Kelas" width="200px"/>
                            <vue-excel-column field="kode" label="Kode" width="300px"/>
                        </vue-excel-editor>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="hideModal('laporan')" type="button" class="btn btn-sm btn-secondary">
                            <i class="fas fa-fw fa-times-circle"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="myModalLabel">Import Data Siswa</h6>
                        <button v-on:click="hideModalImport" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form :action="import_route" method="post" enctype="multipart/form-data">
                        <input type="hidden" :value="csrfToken" name="_token"/>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-5">
                                    Format File
                                </div>
                                <div class="col">
                                    : <strong>Excel (.xlsx)</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    Format dan Heading
                                </div>
                                <div class="col">
                                    : <strong>Nama - NIS - Tingkat ID - Kelas ID</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    Tingkat ID
                                </div>
                                <div class="col">
                                    : <strong>X (1) - XI (2) - XII (3) - Lulus (4)</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    Kelas ID
                                </div>
                                <div class="col">
                                    : <strong>Lihat Pada Menu Kelas!</strong>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <small>File :</small>
                                <input v-on:change="setExcel" type="file" name="siswa" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-on:click="hideModalImport" type="button" class="btn btn-sm btn-secondary">
                                <i class="fas fa-fw fa-times-circle"></i> Tutup
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-fw fa-save"></i> Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
extend('integer', value => {
    if (/^\d+$/.test(value)) {
        return true;
    } else {
        return 'Field ini harus berupa angka';
    }
});
extend('length_9', value => {
    if ((value.length == 9)) {
        return true;
    } else {
        return 'Field harus berisi 9 karakter';
    }
});
export default {
    props: [
        'import_route',
    ],
    data () {
        return {
            csrfToken: '',
            columns: [
                {field: 'nama', label: 'Nama'},
                {field: 'nis', label: 'NIS'},
                {field: 'kelas', label: 'Kelas'},
                {field: 'kode', label: 'Kode'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
            tingkat: [],
            kelas: [],
            form: {
                nama: '',
                nis: '',
                tingkat_id: '',
                kelas_id: ''
            },
            form_filter: {
                tingkat_id: '',
                kelas_id: ''
            },
            update_status: false,
            siswa_id: '',
        }
    },
    mounted () {
        this.formData();
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.post('/siswa/lists', this.form_filter)
            .then(response => {
                this.rows = [];
                if (response.data.length == 0) {
                    loader.hide();
                    this.$toastr.info('Data <b>Siswa</b> kosong.');
                } else {
                    this.mappingData(response.data);
                    loader.hide();
                    this.$toastr.success('Pengambilan data <b>Siswa</b> berhasil.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async formData () {
            await axios.get('/siswa/form')
            .then(response => {
                this.tingkat = response.data.tingkat;
                this.kelas = response.data.kelas;
            }).catch(error => {
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async save () {
            let loader = this.$loading.show();
            if (this.update_status == false) {
                await axios.post('/siswa/store', this.form)
                .then(response => {
                    if (!response.data.status) {
                        let tingkat = this.tingkat.find(x => x.id == this.form.tingkat_id);
                        let kelas = this.kelas.find(x => x.id == this.form.kelas_id);
                        this.rows.push({
                            id: response.data.id,
                            tingkat_id: tingkat.id,
                            kelas_id: kelas.id,
                            nama: this.form.nama,
                            nis: this.form.nis,
                            kelas: tingkat.nama + '-' + kelas.nama,
                            kode: 'kodesaya',
                        });
                        this.cleanForm();
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Siswa</b> berhasil ditambahkan.');
                    } else {
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Siswa</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Store : ' + error.message);
                });
            } else {
                await axios.post('/siswa/update/' + this.siswa_id, this.form)
                .then(response => {
                    if (!response.data.status) {
                        let index = this.rows.findIndex(x => x.id == this.siswa_id);
                        let tingkat = this.tingkat.find(x => x.id == this.form.tingkat_id);
                        let kelas = this.kelas.find(x => x.id == this.form.kelas_id);
                        this.rows[index].id = this.siswa_id;
                        this.rows[index].tingkat_id = this.form.tingkat_id;
                        this.rows[index].kelas_id = this.form.kelas_id;
                        this.rows[index].nama = this.form.nama;
                        this.rows[index].nis = this.form.nis;
                        this.rows[index].kelas = tingkat.nama + '-' + kelas.nama;
                        this.cleanForm();
                        this.siswa_id = '';
                        this.update_status = false;
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Siswa</b> berhasil Diubah.');
                    } else {
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Siswa</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Update : ' + error.message);
                });
            }
        },
        async destroy (id) {
            let loader = this.$loading.show();
            await axios.get('/siswa/destroy/' + id)
            .then(response => {
                if (response.data.status == 'relasi tersedia') {
                    loader.hide();
                    this.$toastr.info('Beberapa data <b>Pengaduan</b> terkait <b>Siswa</b> ini.');
                } else {
                    let index = this.rows.findIndex(x => x.id == id);
                    this.rows.splice(index, 1);
                    loader.hide();
                    this.$toastr.success('Data <b>Siswa</b> berhasil dihapus.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Destroy : ' + error.message);
            });
        },
        confirmDestroy (id) {
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Data siswa akan dihapus permanen.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.destroy(id);
                }
            });
        },
        async hapusBanyak (id) {
            let loader = this.$loading.show();
            await axios.post('/siswa/hapus-banyak', {
                id: id
            })
            .then(response => {
                let terhapus = response.data.terhapus;
                let tidak_terhapus = response.data.tidak_terhapus;
                if (terhapus.length > 0) {
                    terhapus.forEach(item => {
                        let index = this.rows.findIndex(x => x.id == item);
                        this.rows.splice(index, 1);
                    });
                }
                if (tidak_terhapus.length > 0) {
                    loader.hide();
                    this.$toastr.info(tidak_terhapus.length + ' data tidak dapat dihapus, karena memiliki data pengaduan.');
                } else {
                    loader.hide();
                    this.$toastr.success(terhapus.length + ' data <b>Siswa</b> berhasil dihapus.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Destroy : ' + error.message);
            });
        },
        confirmHapusBanyak () {
            let siswa = this.$refs['my-table'].selectedRows;
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: siswa.length + ' data siswa akan dihapus permanen.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then(result => {
                if (result.isConfirmed == true) {
                    let id = [];
                    siswa.forEach(item => {
                        id.push(item.id);
                    });
                    this.hapusBanyak(id);
                }
            });
        },
        async ubahKode (kode, id) {
            let loader = this.$loading.show();
            await axios.post('/siswa/ubah-kode/' + id, {
                kode: kode
            })
            .then(response => {
                let index = this.rows.findIndex(x => x.id == id);
                this.rows[index].kode = kode;
                loader.hide();
                this.$toastr.success('Kode <b>Siswa</b> berhasil dibuah.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Ubah Kode : ' + error.message);
            });
        },
        setExcel (event) {
            let file = event.target.files[0].name;
            let reg = /(.*?)\.(xlsx)$/;
            if (!file.match(reg)) {
                this.$toastr.error('Filed ini harus brupa file <b>Excel (.xlsx)</b>');
                event.target.value = '';
            }
        },
        setKode (id) {
            let siswa = this.rows.find(x => x.id == id);
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Anda akan mengganti kode siswa yang dipakai untuk login.',
                input: 'text',
                inputValue: siswa.kode,
                showCancelButton: true,
                cancelButtonText: 'Batalkan',
                confirmButtonText: 'Konfirmasi',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silahkan masukan kode!'
                    }
                }
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.ubahKode(result.value, id);
                }
            });
        },
        edit (id) {
            let siswa = this.rows.find(x => x.id == id);
            this.form.nama = siswa.nama;
            this.form.nis = siswa.nis;
            this.form.tingkat_id = siswa.tingkat_id;
            this.form.kelas_id = siswa.kelas_id;
            this.update_status = true;
            this.siswa_id = id;
            this.showModal('save');
        },
        mappingData (array) {
            array.forEach(item => {
                this.rows.push({
                    id: item.id,
                    tingkat_id: item.tingkat.id,
                    kelas_id: item.kelas.id,
                    nama: item.nama,
                    nis: item.nis,
                    kelas: item.tingkat.nama + '-' + item.kelas.nama,
                    kode: item.kode
                });
            });
        },
        cleanForm () {
            this.form.nama = '';
            this.form.nis = '';
            this.form.tingkat_id = '';
            this.form.kelas_id = '';
        },
        classInput(error) {
            if (error) {
                return 'form-control is-invalid';
            } else {
                return 'form-control';
            }
        },
        showModal (type) {
            if (type == 'save') {
                $('#saveModal').modal('show');
            } else {
                $('#laporanModal').modal('show');
            }
        },
        hideModal (type) {
            this.update_status = false;
            this.cleanForm();
            if (type == 'save') {
                $('#saveModal').modal('hide');
            } else {
                $('#laporanModal').modal('hide');
            }
        },
        showModalImport () {
            $('#importModal').modal('show');
        },
        hideModalImport () {
            $('#importModal').modal('hide');
        },
    }
}
</script>