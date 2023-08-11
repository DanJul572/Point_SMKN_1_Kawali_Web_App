<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Guru
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
                            <i class="fas fa-fw fa-plus-square"></i> Tamdah Data Guru
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
                            <span v-if="props.column.field == 'aksi'">
                                <button v-on:click="edit(props.row.id)" class="btn btn-xs btn-success">
                                   <i class="fas fa-fw fa-edit"></i>
                                </button>
                                <button v-on:click="confirmDestroy(props.row.id)" class="btn btn-xs btn-danger">
                                   <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </span>
                            <span v-else-if="props.column.field == 'kode'">
                                <a v-on:click="setKode(props.row.id)" href="#">{{ props.row.kode }}</a>
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
        <!-- Save Modal -->
        <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="saveModalLabel">Form Data Guru</h6>
                                <button v-on:click="hideModal('save')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Nama :</small>
                                        <input v-model="form.nama" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required|integer" v-slot="{ errors }">
                                        <small>No HP :</small>
                                        <input v-model="form.nip" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button v-on:click="hideModal('save')" type="button" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-fw fa-times-circle"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm">
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
                        <h6 class="modal-title" id="myModalLabel">Laporan Daftar Guru</h6>
                        <button v-on:click="hideModal('laporan')" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <vue-excel-editor v-model="rows" ref="grid" readonly>
                            <vue-excel-column field="nama" label="Nama" width="300px"/>
                            <vue-excel-column field="nip" label="NIP" width="200px"/>
                            <vue-excel-column field="kode" label="Kode" width="220px"/>
                        </vue-excel-editor>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="hideModal('laporan')" type="button" class="btn btn-secondary btn-sm">
                            <i class="fas fa-fw fa-times-circle"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Import -->
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
                                    : <strong>Nama - NIP</strong>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <small>File :</small>
                                <input v-on:change="setExcel" type="file" name="guru" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-on:click="hideModalImport" type="button" class="btn btn-secondary btn-sm">
                                <i class="fas fa-fw fa-times-circle"></i> Tutup
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
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
export default {
    props: [
        'import_route',
    ],
    data () {
        return {
            csrfToken: '',
            columns: [
                {field: 'nama', label: 'Nama'},
                {field: 'nip', label: 'No HP'},
                {field: 'kode', label: 'Kode'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
            form: {
                nama: '',
                nip: '',
            },
            update_status: false,
            guru_id: '',
        }
    },
    mounted () {
        this.lists();
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.get('/guru/lists')
            .then(response => {
                this.rows = response.data;
                loader.hide();
                this.$toastr.success('Pengambilan data <b>Guru</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async save () {
            let loader = this.$loading.show();
            if (this.update_status == false) {
                await axios.post('/guru/store', this.form)
                .then(response => {
                    if (!response.data.status) {
                        this.rows.push({
                            id: response.data.id,
                            nama: this.form.nama,
                            nip: this.form.nip,
                            kode: 'kodesaya',
                        });
                        this.cleanForm();
                        this.hideModal('save');
                        this.mappingData();
                        loader.hide();
                        this.$toastr.success('Data <b>Guru</b> berhasil ditambahkan.');
                    } else {
                        this.cleanForm();
                        this.hideModal('save');
                        this.mappingData();
                        loader.hide();
                        this.$toastr.info('Data <b>Guru</b> sudag tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Store : ' + error.message);
                });
            } else {
                await axios.post('/guru/update/' + this.guru_id, this.form)
                .then(response => {
                    if (!response.data.status) {
                        let index = this.rows.findIndex(x => x.id == this.guru_id);
                        this.rows[index].id = this.guru_id;
                        this.rows[index].nama = this.form.nama;
                        this.rows[index].nip = this.form.nip;
                        this.cleanForm();
                        this.guru_id = '';
                        this.update_status = false;
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Guru</b> berhasil Diubah.');
                    } else {
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Guru</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Update : ' + error.message);
                });
            }
        },
        async ubahKode (kode, id) {
            let loader = this.$loading.show();
            await axios.post('/guru/ubah-kode/' + id, {
                kode: kode
            })
            .then(response => {
                let index = this.rows.findIndex(x => x.id == id);
                this.rows[index].kode = kode;
                loader.hide();
                this.$toastr.success('Kode <b>Guru</b> berhasil dibuah.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Ubah Kode : ' + error.message);
            });
        },
        async destroy (id) {
            let loader = this.$loading.show();
            await axios.get('/guru/destroy/' + id)
            .then(response => {
                if (response.data.status == 'relasi tersedia') {
                    loader.hide();
                    this.$toastr.info('Beberapa data <b>Pengaduan</b> terkait <b>Guru</b> ini.');
                } else {
                    let index = this.rows.findIndex(x => x.id == id);
                    this.rows.splice(index, 1);
                    loader.hide();
                    this.$toastr.success('Data <b>Guru</b> berhasil dihapus.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Destroy : ' + error.message);
            });
        },
        edit (id) {
            let guru = this.rows.find(x => x.id == id);
            this.form.nama = guru.nama;
            this.form.nip = guru.nip;
            this.update_status = true;
            this.guru_id = id;
            this.showModal('save');
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
            let guru = this.rows.find(x => x.id == id);
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Anda akan mengganti kode guru yang dipakai untuk login.',
                input: 'text',
                inputValue: guru.kode,
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
        confirmDestroy (id) {
            this.$swal({
                title: 'Apakah anda yakin ?',
                text: 'Data guru akan dihapus permanen.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.destroy(id);
                }
            });
        },
        mappingData () {
            this.rows.sort((a, b) => {
                var stringA = a.nama.toLowerCase(), stringB = b.nama.toLowerCase();
                if (stringA < stringB) {
                    return -1;
                }
                if (stringA > stringB) {
                    return 1;
                }
                return 0;
            });
        },
        cleanForm () {
            this.form.nama = '';
            this.form.nip = '';
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
