<template>
  <div id="components-layout-demo-basic" >
    <a-layout >
    <a-row>
      <a-col :xs="{ span: 18, offset: 3 }" :lg="{ span: 6, offset: 9 }"> 
      <a-layout-content>
        <a-row >
          <a-col style="textAlign: center">
            <h1>EatInMore</h1>
          </a-col>
        </a-row>
        <a-row>
          <a-col  >
            <p class="height-100">
                <a-card  :bordered="false" style="margin:auto; box-shadow: 0px 0px 30px 0px #666;border-radius: 5px;background-color: rgb(236, 238, 241);color: #ecf0f1;" >
                  <slot/>
                </a-card>
            </p>
          </a-col>
          <a-col :span="9">
          </a-col>
        </a-row>
      </a-layout-content>
      </a-col>
    </a-row>
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



</style>
