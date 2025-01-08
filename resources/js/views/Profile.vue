<template>
    <Topbar/>
    <Sidebar/>
    <div class="content-wrapper" style="min-height: 100vh;">
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
            </div>
        </div>
        </div>

        <div class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-4 mb-3 d-flex align-items-center">
                            <span>Full Name</span>
                        </div>
                        <div class="col-sm-8 mb-3">
                            <span class="form-control role-display">{{full_name}}</span>
                            <input
                                type="text"
                                name="full_name"
                                id="full_name"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="full_name"
                            />
                            <small id="" v-if="errors.full_name" class="text-danger">{{ errors.full_name[0] }}</small>
                        </div>

                        <div class="col-sm-4 mb-3 d-flex align-items-center">
                            <span>Email</span>
                        </div>
                        <div class="col-sm-8 mb-3">
                            <span class="form-control role-display">{{email}}</span>
                            <input
                                type="text"
                                name="email"
                                id="email"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="email"
                            />
                            <small id="" v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                        </div>

                        <div class="col-sm-12 mt-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger btn-input d-none ml-1" @click="cancelEdit">Cancel</button>
                            <button type="button" class="btn btn-success btn-input d-none ml-1" @click="saveUser">Save</button>
                            <button type="submit" class="btn btn-primary btn-display ml-1" @click="editUser" >Edit</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>


        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Change Password</h1>
                </div>
            </div>
        </div>
        </div>


        <div class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-4 mb-3 d-flex align-items-center">
                            <span>Old Password</span>
                        </div>
                        <div class="col-sm-8 mb-3">
                            <input
                                type="password"
                                name="password_old"
                                id="password_old"
                                class="form-control"
                                placeholder=""
                                aria-describedby=""
                                v-model="password_old"
                            />
                            <small id="" v-if="password_errors.password_old" class="text-danger">{{ password_errors.password_old[0] }}</small>
                        </div>

                        <div class="col-sm-4 mb-3 d-flex align-items-center">
                            <span>New Password</span>
                        </div>
                        <div class="col-sm-8 mb-3">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder=""
                                aria-describedby=""
                                v-model="password"
                            />
                            <small id="" v-if="password_errors.password" class="text-danger">{{ password_errors.password[0] }}</small>
                        </div>

                        <div class="col-sm-4 d-flex align-items-center">
                            <span>Confirm Password</span>
                        </div>
                        <div class="col-sm-8">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                placeholder=""
                                aria-describedby=""
                                v-model="password_confirmation"
                            />
                            <small id="" v-if="password_errors.password_confirmation" class="text-danger">{{ password_errors.password_confirmation[0] }}</small>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary ml-1" @click="updatePassword">Update Password</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger ml-1" @click="deleteAccount">Delete Account</button>
                </div>
            </div>
        </div>
        </div>

    </div>

</template>

<script>
    import Topbar from '../components/Topbar.vue';
    import Sidebar from '../components/Sidebar.vue';
    import { useToast } from "vue-toastification";

    export default {
        name: 'Role',
        components: {
            Topbar,
            Sidebar
        },
        data() {
            return {
                errors: {},
                password_errors: {},
                user: {},
                full_name: '',
                email: '',
                password_old: '',
                password: '',
                password_confirmation: '',
            }
        }, 
        methods: {
            async getUser() {
              try {
                const response = await axios.get('/user', {});
                this.user = response.data.data??{};
                this.full_name = this.user.full_name??'';
                this.email = this.user.email??'';
              } catch (error) {
                this.user = {};
              }
            },
            editUser() {
                $('.role-display').addClass('d-none');
                $('.role-input').removeClass('d-none');
                $('.btn-input').removeClass('d-none');
                $('.btn-display').addClass('d-none');
            },
            cancelEdit() {
                $('.role-display').removeClass('d-none');
                $('.role-input').addClass('d-none');
                $('.btn-input').addClass('d-none');
                $('.btn-display').removeClass('d-none');

                this.full_name = this.user.full_name??'';
                this.email = this.user.email??'';
                this.error = {};
            },
            saveUser() {
                this.saveUserData();
            },

            async saveUserData() {
                try {

                    const response = await axios.put('/user', {
                        full_name: this.full_name,
                        email: this.email,
                    });
                    
                    const toast = useToast();
                    if (response.status == 200) {
                        toast.success(response.data.message);
                    }

                    this.user = response.data.data??{};

                    if (this.user !== {}) {
                        localStorage.setItem('user', JSON.stringify(this.user));
                    }

                    this.full_name = this.user.full_name??'';
                    this.email = this.user.email??'';

                    $('.role-display').removeClass('d-none');
                    $('.role-input').addClass('d-none');
                    $('.btn-input').addClass('d-none');
                    $('.btn-display').removeClass('d-none');

                    this.errors = {}

                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            },
            async updatePassword() {
                try {
                    const response = await axios.put('/user/password', {
                        password_old: this.password_old,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    });

                    const toast = useToast();
                    if (response.status == 200) {
                        toast.success(response.data.message);
                    }

                    this.error = {};
                    this.password_errors = {};
                    this.password_old = '';
                    this.password = '';
                    this.password_confirmation = '';
                } catch (error) {
                    this.password_errors = error.response.data.errors;
                }
            }, 
            async deleteAccount() {
                try {
                    const result = window.confirm("Are you sure you want to delete your account?");
                    if (result) {
                        const response = await axios.delete('/user', {});
                        const toast = useToast();
                        if (response.status == 200) {
                            toast.success(response.data.message, {
                                onClose: () => {
                                    localStorage.removeItem('token');
                                    localStorage.removeItem('user');
                                    localStorage.removeItem('role');
                                    
                                    this.$router.push('/login');
                                }
                            });
                        }
                    } 
                } catch (error) {
                    console.log(error);
                    // this.errors = error.response.data.errors;
                }
            }
        },
        mounted() {
            this.getUser();
        }
    }
</script>

<style scoped>
</style>