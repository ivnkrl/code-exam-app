<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="sidebar">
    <div class="user-panel mt-1 pb-1 mb-1 d-flex justify-content-center">
      <div class="info">
        <RouterLink :to="{name:'Home'}" class=""><h3>Code Exam</h3></RouterLink>
      </div>
    </div>
    <div class="user-panel d-flex flex-column justify-content-center align-items-center">
      <div class="user-info">
        <h4>{{user.full_name??""}}</h4>
      </div>
      <div class="user-info mb-2">
        <span>{{role.role_name??""}}</span>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <RouterLink :to="{name:'Dashboard'}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink :to="{name:'Profile'}" class="nav-link">
            <i class="nav-icon fa-solid fa-user"></i>
            <p>Profile</p>
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink :to="{name:'Role'}" class="nav-link">
            <i class="nav-icon fa-solid fa-briefcase"></i>
            <p>Role</p>
          </RouterLink>
        </li>
        <li class="nav-item">
          <a @click="logout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>


  </div>
</aside>
</template>

<script>
  export default {
      name: 'Sidebar',
      data() {
          return {
              token: localStorage.getItem('token'),
              user: {},
              role: {}
          };
      },
      methods: {
          async logout() {
                try {
                    const response = await axios.post('/logout', {});
                    console.log('User:', response);
                    localStorage.removeItem('token');
                    this.$router.push('/login');
                  } catch (error) {
                    if (error.response && error.response.messagge === 'Unauthenticated') {
                      localStorage.removeItem('token');
                      this.$router.push('/login');
                    }
                }
            },

            async getUser() {
                try {
                  const response = await axios.get('/user', {});
                  this.user = response.data.data??{};
                } catch (error) {
                  this.user = {};
                }
            },
            async getRole() {
              try {
                const response = await axios.get('/role', {});
                this.role = response.data.data??{};
              } catch (error) {
                this.role = {};
              }
            },
            async attachUserRole() {
                const user = localStorage.getItem('user');
                const role = localStorage.getItem('role');

                if (user) {
                  this.user = JSON.parse(user);
                } else {
                  this.getUser();
                }

                if (role) {
                  this.role = JSON.parse(role);
                } else {
                  this.getRole();
                }
            }

      },
      mounted() {
        this.attachUserRole();
      },
  }
</script>

<style scoped>
  .user-info {
    color: #fff;
  }
</style>