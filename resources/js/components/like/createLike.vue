<template>
  <v-btn icon text small class="ml-4 mb-2 right" @click="like" >
        <v-icon :color="liked ? 'blue' : ''" >fas fa-heart</v-icon> {{ count }}
    </v-btn>
</template>

<script>
import Axios from 'axios';
export default {

    props : ['reply'],
    data()
    {
        return {
            count : this.reply.likes_count,
            liked : false
        };
    },
    methods : {
        like()
        {
            if(!User.loggedIn())
            {
                this.$router.push({
                    name : 'login'
                })
            }
            else
            {
                this.liked ? this.unlikeIt() : this.likeIt();
                this.liked = !this.liked;
            }
        },
        likeIt()
        {
            this.$Progress.start();
            Axios.post(`/api/${this.reply.id}/like`)
            .then((response) => {
                this.increase();
                this.$Progress.finish();
            })
            .catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)
            });

        },
        unlikeIt()
        {
            this.$Progress.start();
            Axios.delete(`/api/${this.reply.id}/like`)
            .then((response) => {
                this.decrease();
                this.$Progress.finish();
            })
            .catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)

            });
        },
        increase()
        {
            this.count++;
        },
        decrease()
        {
            this.count--;
        },

    },
    created()
    {
        this.liked = this.reply.user_likes.includes(User.id())
    }

}
</script>
