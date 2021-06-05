<template>
  <div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <router-link
        :to="{ name: 'dashboard' }"
        id="asiderTopHeader"
        href=""
        class="brand-link"
      >
        <img
          src="site/backend/dist/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">CodexGround</span>
      </router-link>

      <!-- Sidebar -->
      <div id="customSidebar" class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" id="topSideUserProfile">
          <div class="image">
            <img
              src="site/backend/dist/img/user2-160x160.jpg"
              class="img-circle elevation-2"
              alt="User Image"
            />
          </div>
          <div class="info">
            <a href="" class="d-block">Faisal Tamim</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <li class="nav-item">
              <router-link
                exact-active-class="active"
                class="nav-link"
                :to="{ name: 'dashboard' }"
                ><i class="nav-icon fas fa-th"></i> Dashboard</router-link
              >
            </li>
            <li class="nav-item">
              <router-link
                exact-active-class="active"
                class="nav-link"
                :to="{ name: 'category' }"
                ><i class="fas fa-tag ml-1 mr-2"></i> Mangae
                Category</router-link
              >
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Charts
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Test 1</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Test 2</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  </div>
</template>
