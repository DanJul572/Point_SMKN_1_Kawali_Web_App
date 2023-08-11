<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Poin
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-right">
                        <button v-on:click="showModal('laporan')" class="btn btn-sm btn-success">
                             <i class="fas fa-fw fa-clipboard"></i> Tampilkan Laporan
                        </button>
                        <button v-on:click="[showModal('save'), cleanForm(), update_status = false]" class="btn btn-sm btn-primary">
                            <i class="fas fa-fw fa-plus-square"></i> Tamdah Data Poin
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
                                <div class="d-flex">
                                    <button v-on:click="edit(props.row.id)" class="btn btn-success btn-xs mr-1">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </button>
                                    <button v-on:click="confirmDestroy(props.row.id)" class="btn btn-danger btn-xs">
                                        <i class="fas fa-fw fa-trash"></i>
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
        <!-- Modal -->
        <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="saveModalLabel">Form Data Poin</h6>
                                <button v-on:click="hideModal('save')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Kode Poin :</small>
                                        <input v-model="form.kode" type="text" :class="classInput(errors[0])">
                                        <small class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required|integer" v-slot="{ errors }">
                                        <small>Nilai Poin :</small>
                                        <input v-model="form.nilai" type="text" :class="classInput(errors[0])">
                                        <small class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Deskripsi :</small>
                                        <textarea v-model="form.deskripsi" :class="classInput(errors[0])" cols="30" rows="5"></textarea>
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
                        <h6 class="modal-title" id="myModalLabel">Daftar Poin</h6>
                        <button v-on:click="hideModal('laporan')" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <vue-excel-editor v-model="rows" ref="grid" readonly>
                            <vue-excel-column field="kode" label="Kode" width="150px" />
                            <vue-excel-column field="deskripsi" label="Deskripsi" width="750px" />
                            <vue-excel-column field="nilai" label="Nilai" width="150px" />
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
    data () {
        return {
            columns: [
                {field: 'kode', label: 'Kode'},
                {field: 'deskripsi', label: 'Deskripsi'},
                {field: 'nilai', label: 'Nilai'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
            form: {
                kode: '',
                nilai: '',
                deskripsi: '',
            },
            update_status: false,
            poin_id: '',
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.get('/poin/lists')
            .then(response => {
                this.rows = response.data;
                loader.hide();
                this.$toastr.success('Pengambilan data <b>Poin</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async save () {
            let loader = this.$loading.show();
            if (this.update_status == false) {
                await axios.post('/poin/store', this.form)
                .then(response => {
                    if (!response.data.status) {
                        this.rows.push({
                            id: response.data.id,
                            kode: this.form.kode,
                            nilai: this.form.nilai,
                            deskripsi: this.form.deskripsi,
                        });
                        this.cleanForm();
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Poin</b> berhasil ditambahkan.');
                    } else {
                        this.cleanForm();
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Poin</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Store : ' + error.message);
                });
            } else {
                await axios.post('/poin/update/' + this.poin_id, this.form)
                .then(response => {
                    if (!response.data.status) {
                        let index = this.rows.findIndex(x => x.id == this.poin_id);
                        this.rows[index].id = this.poin_id;
                        this.rows[index].kode = this.form.kode;
                        this.rows[index].nilai = this.form.nilai;
                        this.rows[index].deskripsi = this.form.deskripsi;
                        this.cleanForm();
                        this.poin_id = '';
                        this.update_status = false;
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Poin</b> berhasil Diubah.');
                    } else {
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Poin</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Update : ' + error.message);
                });
            }
        },
        async destroy (id) {
            let loader = this.$loading.show();
            await axios.get('/poin/destroy/' + id)
            .then(response => {
                if (response.status == 'relasi tersedia') {
                    loader.hide();
                    this.$toastr.info('Banyak data yang terkait.');
                } else {
                    let index = this.rows.findIndex(x => x.id == id);
                    this.rows.splice(index, 1);
                    loader.hide();
                    this.$toastr.success('Data <b>Poin</b> berhasil dihapus.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Destroy : ' + error.message);
            });
        },
        edit (id) {
            let poin = this.rows.find(x => x.id == id);
            this.form.kode = poin.kode;
            this.form.nilai = poin.nilai;
            this.form.deskripsi = poin.deskripsi;
            this.update_status = true;
            this.poin_id = id;
            this.showModal('save');
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
        cleanForm () {
            this.form.kode = '';
            this.form.nilai = '';
            this.form.deskripsi = '';
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
    }
}
</script>
