<template>
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
          placeholder="Search todos"
        ></v-text-field>
      </v-responsive>
      <v-spacer></v-spacer>

        <div class="pr-2">
            <router-link to="/register" tag="button">
            <v-btn
            icon
            >
            <v-icon>mdi-login</v-icon>
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

        <v-col cols="6">
            <v-select
            :items="states"
            menu-props="auto"
            label="EN"
            hide-details
            prepend-icon="mdi-translate"
            single-line
            ></v-select>
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
            <v-list-item-title>{{ linkName }}</v-list-item-title>
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
        &copy;{{ new Date().getFullYear() }} — <strong>EatInMore</strong>
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    components: {  },
    data: () => ({
      states:[],
      drawer: false,
      iconsFoot: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
      linksNames: [
        'Welcome',
        'About US',
        'Contact',
        'Terms and Condictions',
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
