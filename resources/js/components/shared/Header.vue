<template>
  <div>
    <v-card tile>
        <v-toolbar flat class="indigo" dark >
        <!-- <v-app-bar-nav-icon @click="drawer = !drawer" ></v-app-bar-nav-icon> -->
        <v-toolbar-title>
            <v-btn to="/"  text >HsForum</v-btn>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <app-notification v-if="loggedIn"></app-notification>
            <v-btn v-for="item in items" :key="item.title"  text :to="item.to" v-if="item.show" >
                 {{ item.title }}
            </v-btn>

            <v-btn text to="/login" v-if="!loggedIn" >
                Login
            </v-btn>
            <v-btn text v-else @click="logout" >
                Logout
            </v-btn>

        </v-toolbar-items>
        </v-toolbar>
    </v-card>
  <!-- <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
      clipped
    >
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title></v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-navigation-drawer> -->
  </div>

</template>
<script>
import Notification from '../notification/notification.vue'
import User from '../../Helpers/User'
export default {

    data()
    {
        return {
            drawer : false,
            items : [
                { title : 'Forum', to : '/forum',show : true },
                { title : 'Ask Question', to : '/ask', show : User.loggedIn() },
                { title : 'Category', to : '/category',show : User.admin() },
            ],
            loggedIn : User.loggedIn(),
        }
    },
    methods : {
        logout()
        {
            User.logout();
        }
    },
    components : {
        appNotification : Notification
    }

}
</script>

<style>

</style>
