<template>
    <div class="container">
    <div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
        <a href="#" class="h1"><b>Register</b></a>
        </div>
        <div class="card-body">
            <!-- <p class="login-box-msg">Sign in to start your session</p> -->

            <form @submit.prevent="login">

                <div class="row">
                    <div class="col-sm-6 mb-1">
                        <label for="" class="form-label">Name</label>
                        <input
                            type="text"
                            name="full_name"
                            id="full_name"
                            class="form-control"
                            placeholder=""
                            aria-describedby=""
                            v-model="full_name"
                        />
                        <small id="" v-if="errors.full_name" class="text-danger">{{ errors.full_name[0] }}</small>
                    </div>

                    <div class="col-sm-6 mb-1">
                        <label for="" class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder=""
                            aria-describedby=""
                            v-model="email"
                        />
                        <small id="" v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                    </div>

                    <div class="col-sm-4 mb-1">
                        <label for="" class="form-label">Assign Role</label>
                        <input
                            type="text"
                            name="role_name"
                            id="role_name"
                            class="form-control"
                            placeholder=""
                            aria-describedby=""
                            v-model="role_name"
                        />
                        <small id="" v-if="errors.role_name" class="text-danger">{{ errors.role_name[0] }}</small>
                    </div>

                    <div class="col-sm-8 mb-1">
                        <label for="" class="form-label">Role Description</label>
                        <input
                            type="text"
                            name="role_description"
                            id="role_description"
                            class="form-control"
                            placeholder=""
                            aria-describedby=""
                            v-model="role_description"
                        />
                        <small id="" v-if="errors.role_description" class="text-danger">{{ errors.role_description[0] }}</small>
                    </div>

                    <div class="col-sm-6 mb-1">
                        <label for="" class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder=""
                            aria-describedby=""
                            v-model="password"
                        />
                        <small id="" v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                    </div>

                    <div class="col-sm-6 mb-1">
                        <label for="" class="form-label">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder=""
                            aria-describedby=""
                            v-model="password_confirmation"
                        />
                        <small id="" v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-8 d-flex align-items-center">
                        <p class="mb-0">Already have an account? <a href="/login" class="text-center">Login</a></p>
                    </div>
                    <div class="col-sm-4 mt-3">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>

</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Register',
        data() {
            return {
                full_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role_name: '',
                role_description: '',
                errors: {}
            };
        },
        methods: {
            async login() {
                try {
                    const response = await axios.post('/register', {
                        full_name: this.full_name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                        role_name: this.role_name,
                        role_description: this.role_description
                    });
                    
                    this.errors = {};
                    this.$router.push('/login');
                } catch (error) {
                    this.errors = error.response?.data?.errors || 'Registration failed';
                }
            },
        },
    }
</script>

<style scoped>

    .login-box {
        width: 700px !important;
    }
    
    .error {
        color: red;
    }

    .container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

</style>