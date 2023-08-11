<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Sanksi
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-right">
                        <button v-on:click="showModal('laporan')" class="btn btn-sm btn-success">
                            <i class="fas fa-fw fa-clipboard"></i> Tampilkan Laporan
                        </button>
                        <button v-on:click="[showModal('save'), cleanForm, update_status = false]" class="btn btn-sm btn-primary">
                            <i class="fas fa-fw fa-plus-square"></i> Tamdah Data Sanksi
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
                                    <button v-on:click="edit(props.row.id)" class="btn btn-success btn-xs mr-2">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </button>
                                    <button v-on:click="confirmDestroy(props.row.id)" class="btn btn-danger btn-xs">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </div>
                            </span>
                            <span v-else-if="props.column.field == 'deskripsi'">
                               <span style="width: 100px;">{{ props.row.deskripsi }}</span>
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
                                <button v-on:click="hideModal('save')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required|integer" v-slot="{ errors }">
                                        <small>Minimal Poin :</small>
                                        <input v-model="form.minimal_poin" type="text" :class="classInput(errors[0])">
                                        <small class="invalid-feedback">
                                            <i  class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Keterangan :</small>
                                        <textarea v-model="form.keterangan" :class="classInput(errors[0])"  cols="30" rows="5"></textarea>
                                        <small class="invalid-feedback">
                                            <i  class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
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
                        <h6 class="modal-title" id="myModalLabel">Daftar Sanksi</h6>
                        <button v-on:click="hideModal('laporan')" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <vue-excel-editor v-model="rows" ref="grid" readonly>
                            <vue-excel-column field="minimal_poin" label="Minimal Poin" width="200px" />
                            <vue-excel-column field="keterangan" label="Keterangan" width="800px" />
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
                {field: 'minimal_poin', label: 'Minimal Poin'},
                {field: 'keterangan', label: 'Keterangan'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
            form: {
                minimal_poin: '',
                keterangan: '',
            },
            update_status: false,
            sanksi_id: '',
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.get('/sanksi/lists')
            .then(response => {
                this.rows = response.data;
                loader.hide();
                this.$toastr.success('Pengambilan data <b>Sanksi</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
        async save () {
            let loader = this.$loading.show();
            if (this.update_status == false) {
                await axios.post('/sanksi/store', this.form)
                .then(response => {
                    if (!response.data.status) {
                        this.rows.push({
                            id: response.data.id,
                            minimal_poin: this.form.minimal_poin,
                            keterangan: this.form.keterangan,
                        });
                        this.cleanForm();
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Sanksi</b> berhasil ditambahkan.');
                    } else {
                        this.cleanForm();
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Sanksi</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Store : ' + error.message);
                });
            } else {
                await axios.post('/sanksi/update/' + this.sanksi_id, this.form)
                .then(response => {
                    if (!response.data.status) {
                        let index = this.rows.findIndex(x => x.id == this.sanksi_id);
                        this.rows[index].id = this.sanksi_id;
                        this.rows[index].minimal_poin = this.form.minimal_poin;
                        this.rows[index].keterangan = this.form.keterangan;
                        this.cleanForm();
                        this.sanksi_id = '';
                        this.update_status = false;
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.success('Data <b>Sanksi</b> berhasil Diubah.');
                    } else {
                        this.hideModal('save');
                        loader.hide();
                        this.$toastr.info('Data <b>Sanksi</b> sudah tersedia.');
                    }
                }).catch(error => {
                    loader.hide();
                    this.$toastr.error('Update : ' + error.message);
                });
            }
        },
        async destroy (id) {
            let loader = this.$loading.show();
            await axios.get('/sanksi/destroy/' + id)
            .then(response => {
                let index = this.rows.findIndex(x => x.id == id);
                this.rows.splice(index, 1);
                loader.hide();
                this.$toastr.success('Data <b>Sanksi</b> berhasil dihapus.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Destroy : ' + error.message);
            });
        },
        edit (id) {
            let sanksi = this.rows.find(x => x.id == id);
            this.form.minimal_poin = sanksi.minimal_poin;
            this.form.keterangan = sanksi.keterangan;
            this.update_status = true;
            this.sanksi_id = id;
            this.showModal('save');
        },
        confirmDestroy (id) {
            this.$swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Data sanksi akan dihapus permanen.',
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
            this.form.minimal_poin = '';
            this.form.keterangan = '';
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
