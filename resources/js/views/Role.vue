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

                        <div class="col-sm-4 mb-3 d-flex align-items-center">
                            <span>Role Name</span>
                        </div>
                        <div class="col-sm-8 mb-3">
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

                        <div class="col-sm-4 d-flex align-items-center">
                            <span>Role Description</span>
                        </div>
                        <div class="col-sm-8">
                            <span class="form-control role-display">{{description}}</span>
                            <input
                                type="text"
                                name="description"
                                id="description"
                                class="form-control d-none role-input"
                                placeholder=""
                                aria-describedby=""
                                v-model="description"
                            />
                            <small id="" v-if="errors.description" class="text-danger">{{ errors.description[0] }}</small>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger btn-input d-none ml-1" @click="cancelEdit">Cancel</button>
                            <button type="button" class="btn btn-success btn-input d-none ml-1" @click="saveRole">Save</button>
                            <button type="submit" class="btn btn-danger btn-display ml-1" @click="deleteRole" >Delete Role</button>
                            <button type="submit" class="btn btn-primary btn-display ml-1" id="editRoleBtn" @click="editRole" >Edit</button>
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
                role: {},
                role_name: '',
                description: '',
            }
        }, 
        methods: {
            async getRole() {
              try {
                const response = await axios.get('/role', {});
                this.role = response.data.data??{};
                this.role_name = this.role.role_name??'sdas';
                this.description = this.role.description??'dasd';
              } catch (error) {
                this.role = {};
                if (error.response.status == 404) {
                    $('#editRoleBtn').text('Add');
                }
                
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

                this.errors = {};
                this.role_name = this.role.role_name??'';
                this.description = this.role.description??'';
            },
            saveRole() {
                this.saveRoleData();
            },
            async saveRoleData() {
                try {
                    const response = await axios.put('/role', {
                        role_name: this.role_name,
                        description: this.description,
                    });

                    const toast = useToast();
                    if (response.status == 200) {
                        toast.success(response.data.message);
                    }

                    this.role = response.data.data??{};

                    if (this.role !== {}) {
                        localStorage.setItem('role', JSON.stringify(this.role));
                        $('#editRoleBtn').text('Edit');
                    }

                    this.role_name = this.role.role_name??'';
                    this.description = this.role.description??'';
                    this.errors = {}

                    $('.role-display').removeClass('d-none');
                    $('.role-input').addClass('d-none');
                    $('.btn-input').addClass('d-none');
                    $('.btn-display').removeClass('d-none');

                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }, 
            async deleteRole() {
                try {
                    const result = window.confirm("Are you sure you want to delete this role?");
                    if (result) {
                        const response = await axios.delete('/role', {});
                        const toast = useToast();
                        if (response.status == 200) {
                            toast.success(response.data.message);
                            this.role_name = '';
                            this.description = '';
                            this.role = {};
                            localStorage.removeItem('role');
                        }
                    } 
                } catch (error) {
                    console.log(error);
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