<template>
    <div class="container">
    <div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
        <a href="#" class="h1"><b>Login</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to continue</p>

            <form @submit.prevent="login">
                <div class="mb-3">
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

                <div class="mb-3">
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

                <div class="row">
                    <div class="col-8">

                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>

                    <div class="col-sm-8">
                        <p class="mb-0">New User? <a href="/register" class="text-center">Register</a></p>
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
        name: 'Login',
        data() {
            return {
                email: '',
                password: '',
                errors: {},
            };
        },
        methods: {
            async login() {
                try {
                    const response = await axios.post('/login', {
                        email: this.email,
                        password: this.password,
                    });

                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    localStorage.setItem('role', JSON.stringify(response.data.role));
                    this.$router.push('/dashboard');
                } catch (error) {
                    this.errors = error.response?.data?.errors || 'Login failed';
                    console.log(this.errors);
                    
                }
            },
        },
    }
</script>

<style scoped>

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