<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">Cek Poin</div>
                <div class="card-body">
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <form method="post" v-on:submit.prevent="handleSubmit(cek)">
                            <ValidationProvider rules="required|integer|length_9" v-slot="{ errors }">
                                <div class="input-group">
                                    <input v-model="nis" type="text" placeholder="NIS Siswa..." :class="classInput(errors[0])">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-check"></i></button>
                                    </div>
                                    <div v-if="errors[0]" class="invalid-feedback">
                                        <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                    </div>
                                </div>
                            </ValidationProvider>
                        </form>
                    </ValidationObserver>
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
    data () {
        return {
            nis: ''
        }
    },
    methods: {
        async cek () {
            let loader = this.$loading.show();
            await axios.post('/poin/cek', {nis: this.nis})
            .then(response => {
                if (response.data.status == 'tidak ada') {
                    loader.hide();
                    this.$toastr.info('Data <b>Siswa</b> tidak ada.');
                } else {
                    loader.hide();
                    this.$swal({
                        title: response.data.total_poin + ' ' + 'Poin',
                        text: response.data.nama,
                    }).then(() => {
                        this.nis = '';
                    });
                }
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Cek : ' + error.message);
            });
        },
        classInput(error) {
            if (error) {
                return 'form-control is-invalid';
            } else {
                return 'form-control';
            }
        },
    }
}
</script>

<style>
    .validation-provider {
        width: 100%;
    }
</style>