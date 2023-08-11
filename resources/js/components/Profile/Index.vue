<template>
    <div>
        <div class="card shadow">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                <ValidationObserver v-slot="{ handleSubmit }">
                    <form v-on:submit.prevent="handleSubmit(cek)" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <ValidationProvider rules="required|space" v-slot="{ errors }">
                                        <small>Username Lama :</small>
                                        <input v-model="form_cek.username" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <ValidationProvider rules="required|space|length_8" v-slot="{ errors }">
                                        <small>Password Lama :</small>
                                        <input v-model="form_cek.password" type="password" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Cek Username & Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </ValidationObserver>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="myModalLabel">Ubah Akun Admin</h6>
                        <button v-on:click="hideModal" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <ValidationObserver v-slot="{ handleSubmit }">
                        <form v-on:submit.prevent="handleSubmit(update)" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Nama :</small>
                                        <input v-model="form.nama" :class="classInput(errors[0])" type="text">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required|space" v-slot="{ errors }">
                                        <small>Username :</small>
                                        <input v-model="form.username" :class="classInput(errors[0])" type="text">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required|space|length_8" v-slot="{ errors }">
                                        <small>Password :</small>
                                        <input v-model="form.password" :class="classInput(errors[0])" type="text">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                        <small>Avatar :</small>
                                        <input v-on:change="setGambar($event)" class="form-control" type="file">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button v-on:click="hideModal" type="button" class="btn btn-sm btn-secondary">
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
    </div>
</template>

<script>
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
extend('space', value => {
    if (/\s/.test(value)) {
        return 'Field ini tidak boleh memiliki spasi';
    } else {
        return true;
    }
});
extend('length_8', value => {
    if ((value.length == 8)) {
        return true;
    } else {
        return 'Field ini minimal berisi 8 karakter';
    }
});
extend('jpg', value => {
    var isValid = /\.jpe?g$/i.test(value.value);
    if (!isValid) {
      return 'Field ini harus berupa gambar';
    } else {
        return isValid;
    }
});
export default {
    data () {
        return {
            form_cek: {
                username: '',
                password: '',
            },
            form: {
                nama: '',
                username: '',
                password: '',
                gambar: ''
            }
        }
    },
    mounted () {

    },
    methods: {
        async cek () {
            let loader = this.$loading.show();
            await axios.post('/admin/cek', this.form_cek)
            .then(response => {
                loader.hide();
                if (response.data.status == 'username salah') {
                    this.$toastr.error('<b>Username</b> yang anda masukan salah.');
                } else if (response.data.status == 'password salah') {
                    this.$toastr.error('<b>Password</b> yang anda masukan salah.');
                } else {
                    this.form_cek.username = '';
                    this.form_cek.password = '';
                    this.showModal();
                }
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Cek : ' + error.message);
            });
        },
        async update () {
            let loader = this.$loading.show();
            await axios.post('/admin/update', this.form)
            .then(response => {
                this.form.nama = '';
                this.form.username = '';
                this.form.password = '';
                this.form.gambar = '';
                this.hideModal();
                loader.hide();
                this.$toastr.success('Akun berhsail diperbaharui.');
            })
            .catch(error => {
                loader.hide();
                this.$toastr.error('Update : ' + error.message);
            });
        },
        setGambar (event) {
            let file = event.target.files[0].name;
            let reg = /(.*?)\.(jpg|bmp|jpeg|png)$/;
            if (!file.match(reg)) {
                this.$toastr.error('Filed ini harus berisi gambar');
                event.target.value = '';
            } else {
                let file = event.target.files[0];
                let reader = new FileReader;
                reader.onloadend = () => {
                    this.form.gambar = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },
        showModal () {
            $('#myModal').modal('show');
        },
        hideModal () {
            $('#myModal').modal('hide');
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
