<template>
<div>
  <nprogress-container></nprogress-container>
  <v-app id="inspire" :dark=true>
    <v-app-bar
      app
      clipped-right
      flat
      height="72"
    >
    <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>

      <v-responsive max-width="500">
        <v-text-field
          dense
          flat
          hide-details
          rounded
          solo-inverted
          :placeholder="$t('search')+' todos'"
        ></v-text-field>
      </v-responsive>
      <v-spacer></v-spacer>
        <div class="pr-2">
            <v-btn
            icon
            color="warning"
            @click="showDialogCart = true"
            >

                <v-badge
                    color="error"
                    overlap
                    dot
                    :value=badgeShow
                >
                    <v-icon>mdi-cart-outline</v-icon>
                </v-badge>
            </v-btn>

        </div>

        <div class="pr-2">

            <template>
                <div class="text-center">
                    <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-width="200"
                    offset-x
                    >
                    <template v-slot:activator="{ on, attrs }">
                        <v-avatar
                            class=""
                            color="brown"
                            size="32"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <span class="white--text headline">{{ iniName }}</span>
                        </v-avatar>

                    </template>

                    <v-card>
                        <v-list dense>
                        <v-list-item>
                            <v-list-item-avatar>
                            <img
                                :src="'storage/'+userAvatar"
                                alt="avatar"
                                @click="changeAvatar()"

                            >
                            </v-list-item-avatar>

                            <v-list-item-content>
                            <v-list-item-title>{{userName}} {{userlastName}}</v-list-item-title>
                            <v-list-item-subtitle>{{userTypeName}}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                            <v-btn
                                class="red--text"
                                icon
                                @click="logout"
                            >
                                <v-icon>mdi-logout</v-icon>
                            </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                        </v-list>

                        <v-divider></v-divider>

                        <v-list dense>
                            <v-list-item>
                                <v-list-item-action>
                                <v-btn icon @click="changeAvatar()">
                                    <v-icon>mdi-camera-account</v-icon>
                                </v-btn>
                                </v-list-item-action>
                                <v-list-item-title>Update avatar</v-list-item-title>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-action>
                                <v-btn icon @click="toggle_dark_mode">
                                    <v-icon>mdi-theme-light-dark</v-icon>
                                </v-btn>
                                </v-list-item-action>
                                <v-list-item-title>Sleep mode</v-list-item-title>
                            </v-list-item>

                        <v-list-item>
                            <v-list-item-action>
                            <v-btn
                                class="red--text"
                                icon
                                @click="logoutAll"
                            >
                                <v-icon>mdi-power</v-icon>
                            </v-btn>
                            </v-list-item-action>
                            <v-list-item-title>Logout All Devices</v-list-item-title>
                        </v-list-item>
                        </v-list>

                        <v-card-actions>
                        <v-spacer></v-spacer>


                        <v-btn
                            color="primary"
                            text
                            @click="editUser()"
                            icon
                        >
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-menu>
                </div>
            </template>

        </div>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      app
    >
        <v-sheet
            class="pa-4"
        >
      <v-img
        src="storage/icons/110x92px.png"
        lazy-src="storage/icons/110x92px.png"
        aspect-ratio="2"
        max-height="150"
        max-width="250"
        contain
      >
        <template v-slot:placeholder>
          <v-row
            class="fill-height ma-0"
            align="center"
            justify="center"
          >
            <v-progress-circular
              indeterminate
              color="grey lighten-5"
            ></v-progress-circular>
          </v-row>
        </template>
      </v-img>

        <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
        >

        </v-row>

        <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
        >

        <v-col cols="8">
            <v-select
            v-model="new_lang"
            :items="langs"
            menu-props="auto"
            label="en"
            hide-details
            prepend-icon="mdi-translate"
            single-line
            @change="changeLocale(new_lang)"
            >
                <template v-slot:selection="{ item }">
                  {{ item.replaceAll('_', ' ').toUpperCase() }}
                </template>
                <template  v-slot:item="{ item }">
                  {{ item.replaceAll('_', ' ').toUpperCase()}}
                </template>
            </v-select>
        </v-col>

        </v-row>

        </v-sheet>
      <v-divider></v-divider>

      <v-list>
        <template
            v-for="(linkName, index)  in linksNames">
            <v-list-item
                v-if="$can(can[index])"
                :key="linkName"
                :to="links[index]"
                link
            >
            <v-list-item-icon>
                <v-icon>{{ icons[index] }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title>{{ linkName }}</v-list-item-title>
            </v-list-item-content>
            </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container
        class="py-8 px-6 mb-8"
        fluid
      >
        <v-row>
          <v-col
            cols="12"
          >
           <loading v-if="$root.loading"></loading>
          <slot v-else/>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-footer padless fixed app >

      <v-col
        class="text-center"
        cols="12"
      >
       <div
            :class="[`text-caption`]"
            class="transition-swing"
        >
        &copy;{{ new Date().getFullYear() }} — <strong>EatInMore</strong>
       </div>
      </v-col>
    </v-footer>
    <!--dialog-->
    <dialogo v-model="showDialog" v-bind:show="showDialog"/>
    <dialogViewCart v-model="showDialogCart" v-bind:showBadge="badgeShow" />

    <dialogoAvatar v-model="showDialogAvatar" v-bind:show="showDialogAvatar"/>
    <div class="main-wrapper">
        <cookie-law theme="blood-orange--rounded"></cookie-law>
    </div>
  </v-app>
  </div>
</template>

<script>
  import NprogressContainer from 'vue-nprogress/src/NprogressContainer'
  import dialogo from '../../Auth/dialogUser.vue';
  import dialogoAvatar from '../../Auth/dialogAvatar.vue';
  import CookieLaw from 'vue-cookie-law';
  import { AbilityBuilder, Ability } from '@casl/ability';
  import {i18n} from '../../../i18n.js'
  import dialogViewCart from '../../Cart/dialogCart.vue';


  export default {
    components: { NprogressContainer,dialogo,dialogoAvatar, CookieLaw, dialogViewCart },

    data: () => ({
        //baseUrl:'http://localhost/cwqafkxr_eat_in_more/public/',
        baseUrl:'https://cwqafkxreatinmore.herokuapp.com/',
      badgeShow:true,
      showDialogCart:false,
      new_lang:null,
      my_lang:null,
      langs: ['en', 'pt_BR'] ,
      showDialogAvatar: false,
      showDialog: false,
      fav: false,
      menu: false,
      message: false,
      hints: false,
      linksNames: [
        'Dashboard',
        'Meals',
        'Chef',
        'Tools',
      ],
      links:[
        'home',
        'mealIndex',
        'chefeNew',
        'tools',
      ],
      icons: [
        'mdi-view-dashboard',
        'mdi-noodles',
        'mdi-chef-hat',
        'mdi-hammer-screwdriver',
      ],

      can: [
        'home',
        'meal_list',
        'chef',
        'admin',
      ],
      states:[],
      drawer: null,
      userInfo: localStorage.getItem('user'),
      userType: '',
      userTypeName: '',
      userName:null,
      userlastName:null,
      iniName: null,
      userAvatar:null,
      modeGet: '',
    }),
  methods: {
    changeLocale(new_lang) {
        if(new_lang != this.my_lang){
            i18n.locale = new_lang;
            this.my_lang=new_lang
            this.setLocale();
        }
    },
    setLocale(){

      axios
        .get('userLocale/'+this.my_lang)
        .then();
    },
    changeAvatar(){
        this.showDialogAvatar = true;
    },
    editUser(){
        this.menu = false;
        this.showDialog = true;

    },
    toggle_dark_mode: function() {
        this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
        this.userMode(this.$vuetify.theme.dark.toString());
    },

    userMode(dark){
      axios
        .get('userMode/'+dark)
        .then();
    },
    userModeGet(){
      axios
        .get('userModeGet')
        .then(response => (this.modeGet = response.data));
    },
    initials(string) {
        var first=string.substring(0, 1)
      return first.toUpperCase();
    },
    logout(){
      this.$store
        .dispatch('logout')
        .then(() => {
          //this.$router.push({ name: 'home' })
        })
        .catch(err => {
            console.log(err);
        })
    },
    darkmode(){

    const theme = localStorage.getItem("dark_theme");
    //console.log(theme);
    if (theme) {
        if (theme === "true") {
            this.$vuetify.theme.dark = true;
        } else {
            this.$vuetify.theme.dark = false;
        }
    } else if (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
        this.$vuetify.theme.dark = true;
        localStorage.setItem(
            "dark_theme",
            this.$vuetify.theme.dark.toString()
        );
    }

    },

    logoutAll(){
      this.$store
        .dispatch('logoutAll')
        .then(() => {
          //this.$router.push({ name: 'home' })
        })
        .catch(err => {
            console.log(err);
        })
    },
    permissions(permissions){
        const { can, rules } = new AbilityBuilder(Ability);
        can(permissions, 'all');
        this.$ability.update(rules);
    },
    abilities(){
        axios
            .get('abilities')
            .then(response => (
            localStorage.setItem('permissions', JSON.stringify(response.data.permissions)),
            this.new_lang=response.data.locale,
            this.changeLocale(this.new_lang),
            this.permissions(response.data.permissions)
            ));
    }

  },

    watch: {
    $route:{
        handler(){
            this.abilities();
        },
        immediate : true
    },
    modeGet (val, oldVal) {
    //console.log(this.modeGet)
    if(this.modeGet){
        var dark =true
    }else{
        var dark = false
    }
    localStorage.setItem("dark_theme", dark);
    this.darkmode();

    }
    },
  mounted() {
    const userData = JSON.parse(this.userInfo);
    this.abilities();
    this.userModeGet();
    this.darkmode();

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

    var userName = userData.logged_in_user.name;
    var userlastName = userData.logged_in_user.lastName;
    this.iniName=this.initials(userName);
    this.userName = userName;
    this.userlastName =userlastName;
    this.userAvatar = userData.logged_in_user.avatar;

  },
  }
</script>
