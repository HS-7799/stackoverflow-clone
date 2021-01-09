<template>
  <div class="text-center">
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
        class="mt-sm-2"
        style="position :relative"
          icon
          dark
          v-bind="attrs"
          v-on="on"
          @click="read"
        >
          <v-icon>fas fa-bell</v-icon>
          <span id="unRead-Notifications" class="red" v-if="showNotifications"  > {{ number }} </span>
        </v-btn>
      </template>
      <v-list>
        <v-list-item>
          <p v-if="number != 0" >{{ number }} new persons replied to your questions</p>
          <p v-else>No new replies</p>
        </v-list-item>
      </v-list>

    </v-menu>
  </div>
</template>

<script>
import Exception from '../../Helpers/Exception';
  export default {
      data : () => ({
          showNotifications : null,
          notifications : {},
          number : 0 // number of unread notifications
      }),
      created()
      {
          this.getNotifications();
      },
      methods : {
          getNotifications()
          {
            axios.get('/api/notifications')
            .then((response) => {
                this.number = response.data.numberOfUnreadNotifications;
                this.notifications = response.data.notifications

                if(this.number != 0)
                {
                    this.showNotifications = true;
                }
            })
            .catch((err) => {
                Exception.handle(err)
            })
          },
          read()
          {
              axios.post('/api/notifications')
              .then((result) => {
                  this.showNotifications = false;
              })

          }
      }
  }
</script>

<style scoped>
#unRead-Notifications {
border-radius: 50%;
position: absolute;
top: -5px;
right: 5px;
padding-top: 2px;
}
</style>
