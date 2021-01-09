<template>
  <div class="grey lighten-5">
    <v-row>
      <v-col>
        <v-card>
            <v-list v-if="replies.length > 0" >
                <app-reply
                    v-for="(reply,index) in replies"
                    :key="reply.id"
                    :reply="reply"
                    :index="index"
                    @replyDeleted="deleteReply($event)"
                ></app-reply>
            </v-list>
            <p v-else class="pa-2" >No replies</p>
        </v-card>
      </v-col>
    </v-row>

  </div>
</template>

<script>
import Reply from '../reply/reply.vue'

export default {

    props : ['replies'],
    components : {
        appReply : Reply
    },
    methods : {
        deleteReply(index)
        {
            this.replies.splice(index,1);
            this.$emit('replyDeleted');
        }
    }
}
</script>

<style>

</style>
