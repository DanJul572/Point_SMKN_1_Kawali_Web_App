<template>
    <div class="card shadow">
        <div class="card-header">
            Kelas
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col text-right">
                    <button v-on:click="create" class="btn btn-sm btn-primary">
                        <i class="fas fa-fw fa-plus-square"></i> Tamdah Data Kelas
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <vue-good-table
                    :columns="columns"
                    :rows="rows"
                    :sort-options="{enabled: false}"
                    :pagination-options="{enabled: true}"
                    :search-options="{enabled: true, trigger: 'enter'}">
                    <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'aksi'">
                               <button v-on:click="edit(props.row.id)" class="btn btn-success btn-xs">
                                   <i class="fas fa-fw fa-edit"></i>
                               </button>
                               <button v-on:click="confirmDestroy(props.row.id)" class="btn btn-danger btn-xs">
                                   <i class="fas fa-fw fa-trash"></i>
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
</template>

<script>
export default {
    data () {
        return {
            data: '',
            columns: [
                {field: 'id', label: 'Kelas ID'},
                {field: 'nama', label: 'Nama'},
                {field: 'aksi', label: 'Aksi'},
            ],
            rows: [],
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        async lists () {
            let loader = this.$loading.show();
            await axios.get('/kelas/lists')
            .then(response => {
                this.rows = response.data;
                loader.hide();
                this.$toastr.success('Pengambilan data berhasil.');
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Data : ' + error.message);
            });
        },
        async store (nama_kelas) {
            let loader = this.$loading.show();
            await axios.post('/kelas/store', {nama: nama_kelas})
            .then(response => {
                if (!response.data.status) {
                    this.rows.push({
                        id: response.data,
                        nama: nama_kelas.toUpperCase(),
                    });
                    loader.hide();
                    this.$toastr.success('Data <b>Kelas</b> berhasil ditambahkan.');
                } else {
                    loader.hide();
                    this.$toastr.info('Data <b>Kelas</b> sudag tersedia.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Store : ' + error.message);
            });
        },
        async update (nama, id) {
            let loader = this.$loading.show();
            let index = this.rows.findIndex(x => x.id == id);
            await axios.post('/kelas/update/' + id, {
                nama: nama
            })
            .then(response => {
                if (!response.data.status) {
                    this.rows[index].nama = nama;
                    loader.hide();
                    this.$toastr.success('Data <b>Kelas</b> berhasil diubah.');
                } else {
                    loader.hide();
                    this.$toastr.info('Data <b>Kelas</b> sudag tersedia.');
                }
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Store : ' + error.message);
            });
        },
        edit (id) {
            let kelas = this.rows.find(x => x.id == id);
            this.$swal({
                title: 'Ubah Nama Kelas!',
                text: 'Anda akan mengubah nama kelas.',
                input: 'text',
                inputValue: kelas.nama,
                showCancelButton: true,
                inputPlaceholder: 'Masukan Nama Kelas.',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silahkan masukan nama kelas!'
                    }
                }
            })
            .then(result => {
                if (result.isConfirmed == true) {
                    this.update(result.value, id);
                }
            });
        },
        create () {
            this.$swal({
                title: 'Tambah Data Kelas!',
                text: 'Anda akan menambahkan data kelas.',
                input: 'text',
                showCancelButton: true,
                inputPlaceholder: 'Masukan Nama Kelas.',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Field ini harus diisi'
                    }
                }
            })
            .then(result => {
                if (result.isConfirmed == true) {
                    this.store(result.value);
                }
            });
        },
        async destroy (id) {
            let loader = this.$loading.show();
            await axios.get('/kelas/destroy/' + id)
            .then(response => {
                if (response.data.status == 'relasi tersedia') {
                    loader.hide();
                    this.$toastr.info('Banyak data <b>Siswa</b> terkait <b>Kelas</b> ini.');
                } else {
                    let index = this.rows.findIndex(x => x.id == id);
                    this.rows.splice(index, 1);
                    loader.hide();
                    this.$toastr.success('Data <b>Kelas</b> berhasil dihapus.');
                }
            }).catch(error => {
                this.$toastr.error('Destroy : ' + error.message);
            });
        },
        confirmDestroy (id) {
            this.$swal({
                title: 'Apakah anda yakin ?',
                text: 'Data kelas akan dihapus permanen.',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then(result => {
                if (result.isConfirmed == true) {
                    this.destroy(id);
                }
            });
        },
    }
}
</script>
