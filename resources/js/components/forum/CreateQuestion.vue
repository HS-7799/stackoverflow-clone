<template>

    <v-form @submit.prevent="createQuestion" ref="form" v-model="valid" >

      <v-text-field
        v-model="form.title"
        counter="255"
        label="Title"
        :rules="titleRules"
        required
      ></v-text-field>
      <span class="red--text" v-if="errors.title" >
          {{ errors.title[0] }}
      </span>

      <v-select
        v-model="form.category_id"
        :items="categories"
        item-value="id"
        item-text="name"
        :rules="[v => !!v || 'Item is required']"
        label="Category"
        required
      ></v-select>
      <span class="red--text" v-if="errors.category_id" >
          {{ errors.category_id[0].replace('category id','category') }}
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
            Create
        </v-btn>
        <v-btn
        dark
            color="red"
            class="mr-4"
            @click="reset"

            >
            Reset
        </v-btn>
      </div>


    </v-form>
</template>

<script>
import VueSimplemde from 'vue-simplemde'
import Exception from '../../Helpers/Exception';

  export default {
    data: () => ({
      valid: true,
      form : {
          title : null,
          category_id : null,
          body : null
      },
      categories: [],
      errors : {},
      lazy: false,
      titleRules : [
          v => !!v || 'Title is required',
          v => (v && v.length <= 255) || 'Title must be less than 255 characters',
      ]
    }),
    methods : {
        createQuestion()
        {
            this.$Progress.start()
            axios.post('/api/questions',this.form)
            .then((response) => {
                this.$Progress.finish()
                this.$router.push({
                    name : 'readQuestion',
                    params : {
                        slug : response.data.slug
                    }
                });

            }).catch((err) => {
                this.$Progress.fail()
                Exception.handle(err)
                this.errors = err.response.data.errors;
            });
        },
        reset()
        {
            this.$refs.form.reset();
        }
    },
    created()
    {

        if(User.loggedIn())
        {
            axios.get('/api/categories')
            .then((response) => {
                this.categories = response.data.data
            })
            .catch((err) => {
                Exception.handle(err)
            })
        } else {
            this.$router.push('/login');
        }

    },
    components: {
      VueSimplemde
    }

  }
</script>

<style>
  @import '~simplemde/dist/simplemde.min.css';
</style>
