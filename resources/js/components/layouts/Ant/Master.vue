<template>
  <a-layout id="components-layout-demo-responsive">
    <a-layout-sider
      breakpoint="lg"
      collapsed-width="0"
      @collapse="onCollapse"
      @breakpoint="onBreakpoint"
    >
       <img  v-bind:src="'storage/icons/icon.jpg'" class="logo" alt="Icon" />
      <a-menu theme="dark" mode="inline" :default-selected-keys="['1']" :default-open-keys="['sub1']">
          <a-sub-menu key="sub1">
            <span slot="title"><a-icon type="user" />Profile</span>
            <a-menu-item  key="1">      
              <router-link to="/chefeNew" >
                CV
              </router-link>  
            </a-menu-item>
            <a-menu-item key="2">
              option2
            </a-menu-item>
            <a-menu-item key="3">
              option3
            </a-menu-item>
            <a-menu-item key="4">
              option4
            </a-menu-item>
          </a-sub-menu>
          <a-sub-menu key="sub2">
            <span slot="title"><a-icon type="laptop" />subnav 2</span>
            <a-menu-item key="5">
              option5
            </a-menu-item>
            <a-menu-item key="6">
              option6
            </a-menu-item>
            <a-menu-item key="7">
              option7
            </a-menu-item>
            <a-menu-item key="8">
              option8
            </a-menu-item>
          </a-sub-menu>
          <a-sub-menu key="sub3">
            <span slot="title"><a-icon type="notification" />subnav 3</span>
            <a-menu-item key="9">
              option9
            </a-menu-item>
            <a-menu-item key="10">
              option10
            </a-menu-item>
            <a-menu-item key="11">
              option11
            </a-menu-item>
            <a-menu-item key="12">
              option12
            </a-menu-item>
          </a-sub-menu>
      </a-menu>
    </a-layout-sider>
    <a-layout> 

      <a-layout-content :style="{ margin: '24px 16px 0' }">
      <a-breadcrumb style="margin: 16px 0">
        <a-breadcrumb-item>Home</a-breadcrumb-item>
        <a-breadcrumb-item>List</a-breadcrumb-item>
        <a-breadcrumb-item>App</a-breadcrumb-item>
      </a-breadcrumb>
        <div :style="{ padding: '24px', background: '#fff', minHeight: '360px' }">
          <slot/>
        </div>
      </a-layout-content>
      <a-layout-footer style="textAlign: center">
        EatInMore ©2020 {{userTypeName}} Version
      </a-layout-footer>
    </a-layout>
  </a-layout>
</template>
<script>
export default {
  data() {
    return {
      collapsed: false,
      userInfo: localStorage.getItem('user'),
      userType: '',
      userTypeName: '',
    };
  },

  methods: {
    onCollapse(collapsed, type) {
      //console.log(collapsed, type);
    },
    onBreakpoint(broken) {
      //console.log(broken);
    },
  },
  mounted() {
    const userData = JSON.parse(this.userInfo);
    this.userType = userData.logged_in_user.type;
    if (this.userType == 1) {
      this.userTypeName = "Admin"
    }else if (this.userType == 2 ) {
      this.userTypeName = "Client"
    }else if(this.userType == 3){
      this.userTypeName = "Chefe"
    }else{
      this.userTypeName = "No category"
    }

    //console.log(this.userType);
    //console.log([this.userType]);

  },
};
</script>

<style>
#components-layout-demo-responsive .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px 16px 16px 38%;


}
</style>
