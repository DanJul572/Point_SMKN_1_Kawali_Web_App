<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Semester
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col">
                        <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :sort-options="{enabled: false}"
                        :search-options="{enabled: true, trigger: 'enter'}"
                        :pagination-options="{enabled: true}">
                        </vue-good-table>
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
            csrfToken: '',
            columns: [
                {field: 'id', label: 'Semester ID'},
                {field: 'nama', label: 'Nama Semester'},
                {field: 'tahun_ajaran', label: 'Tahun Ajaran'},
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
            await axios.get('/semester/lists')
            .then(response => {
                this.rows = response.data;
                loader.hide();
                this.$toastr.success('Pengambilan data <b>Semester</b> berhasil.');
            }).catch(error => {
                loader.hide();
                this.$toastr.error('Get : ' + error.message);
            });
        },
    }
}
</script>
