<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Tambah Poin Siswa
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-block btn-primary" type="button" data-toggle="modal" data-target="#siswaModal">Siswa Yang Melakukan Pelanggaran</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-block btn-primary" type="button" data-toggle="modal" data-target="#poinModal">Pelanggaran Yang Dilakukan</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-4 p-2">
                                    <img src="/app/main/image/icon/siswa.png" class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div v-if="form.siswa" class="card-body">
                                        <h6 class="card-title">{{ form.siswa.nama }}</h6>
                                        <p class="card-text">{{ form.siswa.nis }}</p>
                                        <p class="card-text"><small class="text-muted">{{ form.siswa.tingkat.nama + '-' + form.siswa.kelas.nama }}</small></p>
                                    </div>
                                    <div v-else class="card-body">
                                        <div class="alert alert-info">Ambil Siswa Terlebih Dahulu.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-4 p-2">
                                    <img src="/app/main/image/icon/poin.png" class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div v-if="form.poin" class="card-body">
                                        <h6 class="card-title">{{ form.poin.kode }}</h6>
                                        <p class="card-text">{{ form.poin.deskripsi }}</p>
                                    </div>
                                    <div v-else class="card-body">
                                        <div class="alert alert-info">Ambil Poin Terlebih Dahulu.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button v-if="(this.form.siswa != '') && (this.form.poin != '')" v-on:click="confirmStore" class="btn btn-primary btn-block">Tambahkan Poin</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Poin Modal -->
        <div class="modal fade" id="poinModal" tabindex="-1" role="dialog" aria-labelledby="poinModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="poinModal">Ambil Pelanggaran</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ValidationObserver v-slot="{ handleSubmit }">
                            <form method="post" class="mb-3" v-on:submit.prevent="handleSubmit(searchPoin)">
                                <ValidationProvider rules="required" v-slot="{ errors }">
                                    <div class="row">
                                        <div class="col-6 ml-auto">
                                            <div class="input-group input-group-sm">
                                                <input v-model="poin_keyword" type="text" :class="classInput(errors[0])" placeholder="Kode atau Deskripsi Pelanggran">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i class="fas fa-fw fa-search"></i></button>
                                                </div>
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ValidationProvider>
                            </form>
                        </ValidationObserver>
                        <vue-good-table
                        :columns="poin_columns"
                        :rows="poin_rows"
                        :search-options="{enabled: true, trigger: 'enter'}"
                        :pagination-options="{enabled: true}">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'aksi'">
                                <div class="d-flex">
                                    <button v-on:click="setPoin(props.row.id)" class="btn btn-primary btn-xs">Ambil</button>
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
        <!-- Siswa Modal -->
        <div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="siswaModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="siswaModal">Ambil Siswa</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ValidationObserver v-slot="{ handleSubmit }">
                            <form method="post" class="mb-3" v-on:submit.prevent="handleSubmit(searchSiswa)">
                                <ValidationProvider rules="required" v-slot="{ errors }">
                                    <div class="row">
                                        <div class="col-6 ml-auto">
                                            <div class="input-group input-group-sm">
                                                <input v-model="siswa_keyword" type="text" :class="classInput(errors[0])" placeholder="Nama atau NIS Siswa">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i class="fas fa-fw fa-search"></i></button>
                                                </div>
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </ValidationProvider>
                            </form>
                        </ValidationObserver>
                        <vue-good-table
                        :columns="siswa_columns"
                        :rows="siswa_rows"
                        :search-options="{enabled: true, trigger: 'enter'}"
                        :pagination-options="{enabled: true}">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'aksi'">
                                <div class="d-flex">
                                    <button v-on:click="setSiswa(props.row.id)" class="btn btn-primary btn-xs">Ambil</button>
                                </div>
                            </span>
                            <span v-else-if="props.column.field == 'kelas'">
                                {{ props.row.tingkat.nama + '-' + props.row.kelas.nama }}
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
</template>

<script>
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
export default {
    props: ['user'],
    data () {
        return {
            form: {
                siswa: '',
                poin: '',
            },
            poin_columns: [
                {field: 'kode', label: 'Kode'},
                {field: 'deskripsi', label: 'Deskripsi'},
                {field: 'aksi', label: 'Aksi'},
            ],
            poin_rows: [],
            poin_keyword: '',
            siswa_columns: [
                {field: 'nama', label: 'Nama'},
                {field: 'nis', label: 'NIS'},
                {field: 'kelas', label: 'Kelas'},
                {field: 'aksi', label: 'Aksi'},
            ],
            siswa_rows: [],
            siswa_keyword: '',
        }
    },
    methods: {
        async store () {
            if ((this.form.siswa == '') || (this.form.poin == '')) {
                this.$toastr.error('<b>Siswa</b> atau <b>Poin</b> belum terisi.');
            } else {
                let loader = this.$loading.show();
                await axios.post('/poin/siswa', {
                    siswa_id: this.form.siswa.id,
                    poin_id: this.form.poin.id,
                })
                .then(response => {
                    this.siswa_keyword = '';
                    this.poin_keyword = '';
                    this.form.siswa = '';
                    this.form.poin = '';
                    this.poin_rows = [];
                    this.siswa_rows = [];
                    loader.hide();
                    this.$toastr.success('Poin <b>Siswa</b> berhasil tersimpan.');
                })
                .catch(error => {
                    loader.hide();
                    this.$toastr.error('Store : ' + error.message);
                });
            }
        },
        async searchPoin () {
            let loader = this.$loading.show();
            this.poin_rows = [];
            await axios.post('/poin/search', {keyword: this.poin_keyword})
            .then(response => {
                if (response.data.length == 0) {
                    loader.hide();
                    this.$toastr.info('Daftar <b>Poin</b> kosong.');
                } else {
                    this.poin_rows = response.data;
                    loader.hide();
                    this.$toastr.success('Pengambilan <b>Poin</b> berhasil.');
                }
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Search Poin : ' + error.message);
            });
        },
        async searchSiswa () {
            let loader = this.$loading.show();
            this.siswa_rows = [];
            await axios.post('/siswa/search', {keyword: this.siswa_keyword})
            .then(response => {
                if (response.data.length == 0) {
                    loader.hide();
                    this.$toastr.info('Daftar <b>Siswa</b> kosong.');
                } else {
                    this.siswa_rows = response.data;
                    loader.hide();
                    this.$toastr.success('Pengambilan <b>Siswa</b> berhasil.');
                }
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Search Siswa : ' + error.message);
            });
        },
        setSiswa (siswa_id) {
            let index = this.siswa_rows.findIndex(x => x.id == siswa_id);
            this.form.siswa = this.siswa_rows[index];
            $('#siswaModal').modal('hide');
        },
        setPoin (poin_id) {
            let index = this.poin_rows.findIndex(x => x.id == poin_id);
            this.form.poin = this.poin_rows[index];
            $('#poinModal').modal('hide');
        },
        classInput(error) {
            if (error) {
                return 'form-control is-invalid';
            } else {
                return 'form-control';
            }
        },
        confirmStore () {
            this.$swal({
                    title: 'Apakah Anda Yakin?',
                    text: 'Data poin siswa akan disimpan.',
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi',
                    cancelButtonText: 'Batalkan',
                })
                .then(result => {
                    if (result.isConfirmed == true) {
                        this.store();
                    }
                });
        },
    }
}
</script>
