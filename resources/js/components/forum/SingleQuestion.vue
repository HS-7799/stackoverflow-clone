<template>
        <v-card class="mb-3 p-2"  >
            <v-card-title>
                    {{ question.title }}
                    <v-spacer></v-spacer>
            <!-- <v-btn >{{ question.replies_count }} replies</v-btn> -->
            </v-card-title>
            <v-card-subtitle >
                {{ question.user }} said {{ question.created_at }}
            </v-card-subtitle>
            <v-card-text class="black--text" v-html="body"  >
            </v-card-text>

            <v-card-actions v-if="isOwner"  >
                <v-btn dark class="orange dark"  @click="edit" >
                    <v-icon>fas fa-edit</v-icon>
                </v-btn>
                <v-btn dark class="red dark" @click="destroy" >
                    <v-icon>fas fa-trash-alt</v-icon>
                </v-btn>
            </v-card-actions>

        </v-card>

</template>

<script>
import {eventBus} from '../../app.js'
export default {

    data() {
        return {
            isOwner : User.ownQuestion(this.question.user_id)
        }
    },
    props : {
        question : {
            type : Object,
        }
    },
    computed : {
        body()
        {
            return md.parse(this.question.body);
        }
    },
    methods : {
        destroy()
        {
            this.$Progress.start();
            axios.delete('/api/questions/'+this.$route.params.slug)
            .then((response) => {
                this.$Progress.finish();
                this.$router.push('/forum')
            })
            .catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)
            })
        },
        edit()
        {
            this.$emit('startEditting')
        }
    }


}
</script>

<style>

</style>
