<template>
    <Topbar/>
    <Sidebar/>
    <div class="content-wrapper" style="min-height: 100vh;">
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Role</h1>
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
                            <span>Role Name</span>
                        </div>
                        <div class="col-8 mb-3">
                            <span class="form-control role-display">{{role_name}}</span>
                            <input
                                type="text"
                                name="role_name"
                                id="role_name"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="role_name"
                            />
                            <small id="" v-if="errors.role_name" class="text-danger">{{ errors.role_name[0] }}</small>
                        </div>

                        <div class="col-4 d-flex align-items-center">
                            <span>Role Description</span>
                        </div>
                        <div class="col-8">
                            <span class="form-control role-display">{{role_description}}</span>
                            <input
                                type="text"
                                name="role_description"
                                id="role_description"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="role_description"
                            />
                            <small id="" v-if="errors.role_description" class="text-danger">{{ errors.role_description[0] }}</small>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger btn-input d-none ml-1" @click="cancelEdit">Cancel</button>
                            <button type="button" class="btn btn-success btn-input d-none ml-1" @click="saveRole">Save</button>
                            <button type="submit" class="btn btn-primary btn-display ml-1" @click="editRole" >Edit</button>
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
                role: {},
                role_name: '',
                role_description: '',
            }
        }, 
        methods: {
            async getRole() {
              try {
                const response = await axios.get('/role', {});
                this.role = response.data.data??{};
                this.role_name = this.role.role_name??'sdas';
                this.role_description = this.role.description??'dasd';
              } catch (error) {
                this.role = {};
                
              }
            },
            editRole() {
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

                this.role_name = this.role.role_name??'';
                this.role_description = this.role.description??'';
            },
            saveRole() {
                this.saveRoleData();
            },
            async saveRoleData() {
                try {
                    const response = await axios.put('/role', {
                        role_name: this.role_name,
                        description: this.role_description,
                    });
                    
                    this.role = response.data.data??{};

                    if (this.role !== {}) {
                        localStorage.setItem('role', JSON.stringify(this.role));
                    }

                    this.role_name = this.role.role_name??'';
                    this.role_description = this.role.description??'';

                    $('.role-display').removeClass('d-none');
                    $('.role-input').addClass('d-none');
                    $('.btn-input').addClass('d-none');
                    $('.btn-display').removeClass('d-none');

                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        mounted() {
            this.getRole();
        }
    }
</script>

<style scoped>
</style>