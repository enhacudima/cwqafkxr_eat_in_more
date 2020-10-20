<template>
  <a-layout id="components-layout-demo-top" class="layout">
    <a-layout-header>
       <img  v-bind:src="'storage/icons/icon.jpg'" class="logo" alt="Icon" />
      <a-menu
        theme="dark"
        mode="horizontal"
        :default-selected-keys="['1']"
        :style="{ lineHeight: '64px' }"
      >
        <a-menu-item key="1">
          Register
        </a-menu-item>
        <a-menu-item key="2">
          <router-link to="/login" class="nav-item nav-link">
            Cancel
          </router-link>
        </a-menu-item>
        <!--<a-menu-item key="3">
          nav 3
        </a-menu-item>-->
      </a-menu>
    </a-layout-header>
    <a-row>
      <a-col :xs="{ span: 20, offset: 2 }" :lg="{ span: 6, offset: 9 }">    
        <a-layout-content :style="{ margin: '0px 0px 0' }" >
          <a-breadcrumb style="margin: 16px 0">
          </a-breadcrumb>
          <div :style="{ padding: '24px', background: '#fff', minHeight: '360px' }">

            <slot/>


          </div>
        </a-layout-content>


      </a-col>
    </a-row>

    <a-layout-footer style="text-align: center;"  >
      EatInMore ©2020
    </a-layout-footer>

    
  </a-layout>
</template>
<style>
#components-layout-demo-top .logo {
  width: 31px;
  height: 31px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px 24px 16px 0;
  float: left;
}

.ant-layout {
 min-height: 100%;
 height: 100vh;
}
</style>
