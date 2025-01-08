<template>
    <Topbar/>
    <Sidebar/>
    <div class="content-wrapper" style="min-height: 100vh;">
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
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
                    <h5 class="card-title">Welcome</h5>

                    <h4 class="card-text ml-3">
                        {{ user.full_name }}
                    </h4>

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
        name: 'Dashboard',
        components: {
            Topbar,
            Sidebar
        },
        data() {
            return {
                user : {}
            };
        },
        mounted() {
            this.getUser();
        },
        methods: {
            async getUser() {
                try {
                    const response = await axios.get('/user', {});
                    this.user = response.data.data??{};
                } catch (error) {
                    this.user = {};
                }
            }
        }
    }
</script>

<style scoped>
</style>