<template>
    <v-form @submit.prevent="submit" >
        <vue-simplemde v-model="form.body"/>
        <span class="red--text" v-if="errors.body" >
            {{ errors.body[0] }}
        </span>
        <div>
            <v-btn color="success" type="submit"  >Reply</v-btn>
        </div>
    </v-form>
</template>

<script>
import VueSimplemde from 'vue-simplemde'

export default {
    components: {
      VueSimplemde
    },
    data : () => ({
        errors : {},
        form : {
            body : null
        }
    }),
    methods : {
        submit()
        {
            this.$Progress.start();
            if(!User.loggedIn())
            {
                this.$router.push({
                    name : 'login'
                });
            }
            axios.post(`/api/questions/${this.$route.params.slug}/replies`,this.form)
            .then((response) => {
                this.$emit('replyCreated',response.data)
                this.form.body = '';
                window.scrollTo(0,0);
                this.$Progress.finish();
                this.errors = {}
            }).catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)
                this.errors = err.response.data.errors;
            });
        }
    }
}
</script>

<style>
  @import '~simplemde/dist/simplemde.min.css';
</style>
