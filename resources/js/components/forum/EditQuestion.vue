<template>

    <v-form v-model="valid" @submit.prevent="edit"  >

      <v-text-field
        v-model="form.title"
        label="Title"
        counter="255"
        required
        :rules="titleRules"
      ></v-text-field>
      <span class="red--text" v-if="errors.title" >
          {{ errors.title[0] }}
      </span>

      <vue-simplemde v-model="form.body"/>
      <span class="red--text" v-if="errors.body" >
          {{ errors.body[0] }}
      </span>

      <div>
        <v-btn
            class="blue lighten-3 mr-4"
            type="submit"
            :disabled="!valid"
            >
            Save
        </v-btn>
        <v-btn
            class="red mr-4"
            @click="cancel"
            >
            Cancel
        </v-btn>

      </div>


    </v-form>
</template>

<script>
import VueSimplemde from 'vue-simplemde'

  export default {
    props : {
        question : {
            type : Object,
        }
    },
    data: () => ({

      form : {
          title : null,
          body : null
      },
      errors : {},
      titleRules : [
          v => !!v || 'Title is required',
          v => (v && v.length <= 255) || 'Title must be less than 255 characters'
      ],
      valid : true
    }),
    components : {
        VueSimplemde
    },
    created()
    {
        this.form.title = this.question.title;
        this.form.body = this.question.body;
    },
    methods : {
        edit()
        {
            this.$Progress.start();
            axios.patch('/api/questions/'+this.$route.params.slug,this.form)
            .then((response) => {
                this.$Progress.finish();
                this.$emit('questionUpdated',this.form)
            }).catch((err) => {
                this.$Progress.fail();
                Exception.handle(err)
                this.errors = err.response.data.errors
            });
        },
        cancel()
        {
            this.$emit('editCancelled');
        }
    }
}

</script>

<style>
  @import '~simplemde/dist/simplemde.min.css';
</style>
