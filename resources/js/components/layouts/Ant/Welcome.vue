<template>
<div>
  <nprogress-container></nprogress-container>
  <v-app id="inspire">
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
            <router-link to="/login" tag="button">
            <v-btn
            text
            small
            >
            <v-icon>{{icon_home}}</v-icon>
            </v-btn>

            </router-link>
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
        src="storage/icons/icon.jpg"
        lazy-src="storage/icons/icon.jpg"
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
        EatInMore
        </v-row>

        <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
        >

        <v-col cols="8">
            <v-select
            v-model="my_lang"
            :items="langs"
            menu-props="auto"
            label="en"
            hide-details
            prepend-icon="mdi-translate"
            single-line
            @change="changeLocale(my_lang)"
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
        <v-list-item
          v-for="(linkName, index)  in linksNames"
          :key="linkName"
          :to="links[index]"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ icons[index] }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ $t(linkName) }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
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
          <!---->
          <slot/>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-footer padless fixed >

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
    <div class="main-wrapper">
        <cookie-law theme="blood-orange--rounded"></cookie-law>
    </div>
  </v-app>
  </div>
</template>

<script>
import NprogressContainer from 'vue-nprogress/src/NprogressContainer'
import CookieLaw from 'vue-cookie-law';
import {i18n} from '../../../i18n.js'
  export default {
    components: { NprogressContainer,CookieLaw },
    name: 'locale-changer',

    methods: {
        changeLocale(locale) {
            i18n.locale = locale;
        }
    },

    mounted() {
        const userData = JSON.parse(this.userInfo);
        if(userData){
            this.icon_home ='mdi-home'
        }
    },

    data: () => ({
      userInfo: localStorage.getItem('user'),
      icon_home: "mdi-account",
      my_lang:'en',
      langs: ['en', 'pt_BR'] ,
      states:[],
      drawer: false,
      iconsFoot: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
      linksNames: [
        'welcome',
        'about_us',
        'contact',
        'terms_and_conditions',
      ],
      links:[
        '/',
        'about',
        'contact',
        'terms',
      ],
      icons: [
        'mdi-noodles',
        'mdi-information',
        'mdi-phone',
        'mdi-hammer-screwdriver',
      ],
    }),
  }
</script>
