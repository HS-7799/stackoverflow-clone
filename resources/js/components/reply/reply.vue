<template>
    <div>
        <v-list-item >
              <v-list-item-content>
                <v-list-item-title class="headline" >
                        {{ reply.user}}
                </v-list-item-title>
                <v-list-item-subtitle> {{ reply.created_at }} </v-list-item-subtitle>


                <app-edit-reply v-if="editing" :reply="reply" @editCancelled="editing = false" ></app-edit-reply>
                <p class="mt-1" v-else >{{ reply.reply }}</p>

        </v-list-item-content>

        </v-list-item>
        <div class="mb-2" v-if="ownReply && !editing" >
                <v-btn small dark class="orange ml-4" @click="startEditing" >
                    <v-icon>fas fa-edit</v-icon>
                </v-btn>
                <v-btn small dark class="red" @click="destroy(reply.id)" >
                    <v-icon>fas fa-trash-alt</v-icon>
                </v-btn>
        </div>
        <app-create-like :reply="reply" ></app-create-like>
        <v-divider></v-divider>
    </div>

</template>

<script>
import editReply from './editReply.vue'
import CreateLike from '../like/CreateLike.vue'
  export default {
    props : ['reply','index'],
    data()
    {
        return {
            ownReply : User.ownReply(this.reply.user_id),
            editing : false
        }
    },
    methods : {

        destroy(id)
        {
            this.$Progress.start();
            axios.delete(`/api/questions/${this.$route.params.slug}/replies/${id}`)
            .then((response) => {
                this.$Progress.finish();
                this.$emit('replyDeleted',this.index);
            })
            .catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)
            })
        },
        startEditing()
        {
            this.editing = true;
        }
    },
    components : {
        appEditReply : editReply,
        appCreateLike : CreateLike,
    }
  }
</script>
