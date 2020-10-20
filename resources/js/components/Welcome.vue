<template>
  <div id="components-layout-demo-basic">
    <a-layout >
      <a-layout-content>
        <a-col :span="12" :offset="6">
          <p class="height-100">
           <h1>EatInMore</h1> 
          </p>
          <img  v-bind:src="'storage/icons/icon.jpg'" class="picture_avatar_welcome" alt="Icon" />
        </a-col>


          
      </a-layout-content>
      <a-layout-footer>

        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/register" class="nav-item nav-link">Register | </router-link>
                    <router-link to="/login" class="nav-item nav-link">Login</router-link>
                </div>
            </div>
        </nav> 
      </a-layout-footer>
    </a-layout>

  </div>
</template>

<style>
#components-layout-demo-basic {
  text-align: center;     


}
#components-layout-demo-basic .ant-layout-header,
#components-layout-demo-basic .ant-layout-footer {
 
}
#components-layout-demo-basic .ant-layout-footer {
  line-height: 1.5;
}
#components-layout-demo-basic .ant-layout-content {

  min-height: 120px;
  line-height: 120px;
  margin-top: 10vh;
}
#components-layout-demo-basic > .ant-layout {
  height: 100vh;
}
#components-layout-demo-basic > .ant-layout:last-child {

}

.picture_avatar_welcome {
  width: 200px;
  height: 250px;
}

</style>
