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

                        <div class="col-4 mb-3 d-flex align-items-center">
                            <span>Full Name</span>
                        </div>
                        <div class="col-8 mb-3">
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

                        <div class="col-4 mb-3 d-flex align-items-center">
                            <span>Email</span>
                        </div>
                        <div class="col-8 mb-3">
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

                        <div class="col-12 mt-3 d-flex justify-content-end">
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

                        <div class="col-4 mb-3 d-flex align-items-center">
                            <span>Old Password</span>
                        </div>
                        <div class="col-8 mb-3">
                            <span class="form-control role-display">{{password_old}}</span>
                            <input
                                type="text"
                                name="password_old"
                                id="password_old"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="password_old"
                            />
                            <small id="" v-if="errors.password_old" class="text-danger">{{ errors.password_old[0] }}</small>
                        </div>

                        <div class="col-4 mb-3 d-flex align-items-center">
                            <span>New Password</span>
                        </div>
                        <div class="col-8 mb-3">
                            <span class="form-control role-display">{{password_new}}</span>
                            <input
                                type="text"
                                name="password_new"
                                id="password_new"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="password_new"
                            />
                            <small id="" v-if="errors.password_old" class="text-danger">{{ errors.password_old[0] }}</small>
                        </div>

                        <div class="col-4 d-flex align-items-center">
                            <span>Confirm Password</span>
                        </div>
                        <div class="col-8">
                            <span class="form-control role-display">{{password_confimation}}</span>
                            <input
                                type="text"
                                name="password_confimation"
                                id="password_confimation"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="password_confimation"
                            />
                            <small id="" v-if="errors.password_confimation" class="text-danger">{{ errors.password_confimation[0] }}</small>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary ml-1">Save</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

    </div>

</template>

<script>
    import Topbar from '../components/Topbar.vue';
    import Sidebar from '../components/Sidebar.vue';
    export default {
        name: 'Role',
        components: {
            Topbar,
            Sidebar
        },
        data() {
            return {
                errors: {},
                user: {},
                full_name: '',
                email: '',
                password_old: '',
                password_new: '',
                password_confimation: '',
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
            }
        },
        mounted() {
            this.getUser();
        }
    }
</script>

<style scoped>
</style>