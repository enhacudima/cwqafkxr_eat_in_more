<template>
    <v-app>
    <v-dialog v-model="dialog" persistent max-width="600px" min-width="360px">
        <div>
            <v-tabs v-model="tab" show-arrows background-color="grey darken-3" icons-and-text dark grow>
                <v-tabs-slider color="purple darken-4"></v-tabs-slider>
                <v-tab v-for="(i,index) in tabs" :key="index">
                    <v-icon large>{{ i.icon }}</v-icon>
                    <div class="caption py-1">{{ i.name }}</div>
                </v-tab>
                    <v-tab-item>
                        <slot/>
                    </v-tab-item>
            </v-tabs>
        </div>
    </v-dialog>
    </v-app>
</template>
<script>
export default {
  data() {
    return {
      dialog: true,
      tab: 0,
      tabs: [
          {name:"Login to EatInMore", icon:"mdi-account"},
      ],
    }
  }
  }
</script> 
<style>

</style>
