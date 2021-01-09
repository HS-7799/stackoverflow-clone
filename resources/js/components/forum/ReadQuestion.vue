<template>
    <div>
        <app-edit-question v-if="editting"
         :question="question"
         @editCancelled="editting = false" @questionUpdated="questionUpdated"  ></app-edit-question>
        <div v-else >
            <div v-if="show" >
                <v-responsive :width="900" class="mb-5" >
                <v-skeleton-loader
                    ref="skeleton"
                    :type="'list-item-three-line'"
                ></v-skeleton-loader>
            </v-responsive>
            </div>
            <div v-else >
                <app-single-question
            :question="question"
            v-if="question"
            @startEditting="editting = true"
            ></app-single-question>
            </div>
        </div>
        <h1>Replies</h1>
        <app-replies v-if="question" :replies="question.replies"></app-replies>
        <app-new-reply v-if="loggedIn" @replyCreated="replyCreated($event)" ></app-new-reply>
        <div v-else>
            <v-btn text to="/login" >Login</v-btn> to reply
        </div>
    </div>
</template>

<script>
import SingleQuestion from './SingleQuestion.vue'
import EditQuestion from './EditQuestion.vue'
import Replies from '../reply/replies.vue'
import newReply from '../reply/newReply.vue'
export default {

    components : {
        appSingleQuestion : SingleQuestion,
        appEditQuestion : EditQuestion,
        appReplies : Replies,
        appNewReply : newReply
    },
    data()
    {
        return {
            question : null,
            editting : false,
            show : true
        }
    },
    created()
    {
        this.getQuestion();

    },
    methods : {
        questionUpdated()
        {
            this.editting = false;
            this.getQuestion();

        },
        getQuestion()
        {
            axios.get('/api/questions/'+this.$route.params.slug)
            .then((response) => {
                this.show = false;
                this.question = response.data.data
            }).catch((err) => {
                Exception.handle(err)
                this.$router.push('/notFound')
            });
        },
        replyCreated(newReply)
        {
            this.question.replies.unshift(newReply);
        }
    },
    computed : {
        loggedIn()
        {
            return User.loggedIn();
        }
    }

}
</script>

<style>

</style>
