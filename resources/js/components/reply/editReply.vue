<template>
    <v-form @submit.prevent="update(reply.id)" >
        <vue-simplemde v-model="body"/>
        <span class="red--text" v-if="errors.body" >
            {{ errors.body[0] }}
        </span>
        <div class="mt-1">
            <v-btn color="success" type="submit">Save</v-btn>
            <v-btn color="red" type="submit" @click="cancel">Cancel</v-btn>
        </div>
    </v-form>
</template>

<script>
import VueSimplemde from 'vue-simplemde'
export default {
    props : ['reply'],
    data : () => ({
        body : null,
        errors : {}
    }),
    methods : {
        update(id)
        {
            this.$Progress.start();
            axios.patch(`/api/questions/${this.$route.params.slug}/replies/${id}`,{body:this.body})
            .then((response) => {
                this.$Progress.finish();
                this.reply.reply = this.body;
                this.cancel();

            })
            .catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)
                this.errors = err.response.data.errors
            })
        },
        cancel()
        {
            this.$emit('editCancelled');
        }
    },
    components : {
        VueSimplemde,
    },
    created()
    {
        this.body = this.reply.reply
    }
}
</script>

<style>
  @import '~simplemde/dist/simplemde.min.css';
</style>
