<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-avatar
        :color="$vuetify.breakpoint.smAndDown ? 'grey darken-1' : 'transparent'"
        size="32"
      ></v-avatar>

      <v-tabs
        centered
        class="ml-n9"
        color="grey darken-1"
      >
        <v-tab
          v-for="(linkName, index)  in linksNames"
          :key="linkName"
          :to="links[index]"
        >
          {{ linkName }} 
        </v-tab>
      </v-tabs>

      <v-avatar
        class="hidden-sm-and-down"
        color="grey darken-1 shrink"
        size="32"
      ></v-avatar>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col
            cols="12"
            sm="2"
          >
            <v-sheet
              rounded="lg"
              min-height="268"
            >
              <!--  -->
            </v-sheet>
          </v-col>

          <v-col
            cols="12"
            sm="8"
          >
            <v-sheet
              min-height="70vh"
              rounded="lg"
              class="spacing-playground pa-2 "
            >
            
            <v-subheader
            >
            <strong>MEALS</strong> 
            </v-subheader>
            <v-divider></v-divider>
            <div class="pt-6">
              <slot/>
            </div>
            </v-sheet>
          </v-col>

          <v-col
            cols="12"
            sm="2"
          >
            <v-sheet
              rounded="lg"
              min-height="268"
            >
              <!--  -->
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-footer padless  >
      
      <v-col
        class="text-center"
        cols="12"
      >
        &copy;{{ new Date().getFullYear() }} — <strong>EatInMore</strong> 
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      linksNames: [
        'Dashboard',
        'Meals',
        'Chef',
        'Updates',
      ],
      links:[
        'home',
        'mealIndex',
        'chefeNew',
        'Updates',
      ],
      icons: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
      userInfo: localStorage.getItem('user'),
      userType: '',
      userTypeName: '',
    }),
  methods: {

  },
  mounted() {
    const userData = JSON.parse(this.userInfo);
    this.userType = userData.logged_in_user.type;
    if (this.userType == 1) {
      this.userTypeName = "Admin"
    }else if (this.userType == 2 ) {
      this.userTypeName = "Client"
    }else if(this.userType == 3){
      this.userTypeName = "Chef"
    }else{
      this.userTypeName = "No category"
    }

    //console.log(this.userType);
    //console.log([this.userType]);

  },
  }
</script>
