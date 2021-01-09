<template>
    <v-form
      @submit.prevent="signUp"
      :lazy-validation="lazy"
      ref="form"
    >

        <v-text-field
            v-model="form.name"
            :rules="nameRules"
            label="Name"
            prepend-icon="fas fa-user"
            required
        ></v-text-field>
        <span class="red--text" v-if="errors.name" >
            {{ errors.name[0] }}
        </span>

        <v-text-field
            v-model="form.email"
            :rules="emailRules"
            label="E-mail"
            type="email"
            prepend-icon="mdi-email"
            required
        ></v-text-field>
        <span class="red--text" v-if="errors.email" >
            {{ errors.email[0] }}
        </span>

        <v-text-field
            v-model="form.password"
            :counter="10"
            :rules="passwordRules"
            label="Password"
            :type="showPassword ? 'text' : 'password'"
            prepend-icon="mdi-lock"
            :append-icon="showPassword ? 'mdi-eye':'mdi-eye-off'"
            @click:append="showPassword = !showPassword"
            required
        >
        </v-text-field>
        <span class="red--text" v-if="errors.password" >
            {{ errors.password[0] }}
        </span>
        <v-text-field
            v-model="form.password_confirmation"
            :counter="10"
            :rules="passwordRules"
            label="Confirm Password"
            :type="showPasswordConfirmation ? 'text' : 'password'"
            prepend-icon="mdi-lock"
            :append-icon="showPasswordConfirmation ? 'mdi-eye':'mdi-eye-off'"
            @click:append="showPasswordConfirmation = !showPasswordConfirmation"
            required
        >
        </v-text-field>


      <v-btn
        :disabled="!valid"
        class="blue lighten-3 mr-4"
        @click="signUp"
      >
        Sign up
      </v-btn>

      <v-btn
        color="error"
        class="mr-4"
        @click="reset"
      >
        Reset
      </v-btn>
    </v-form>
</template>

<script>
  export default {
    data: () => ({
      form : {
          name : null,
          email : null,
          password : null,
          password_confirmation : null,
      },
      errors : {},
      showPassword : false,
      showPasswordConfirmation : false,
      valid: true,
      passwordRules: [
        v => !!v || 'Password is required',
        v => (v && v.length >=6) || 'Password must be more than 6 characters',
        v => (v  && v.length <= 10) || 'Password must be less than 10 characters',
      ],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      nameRules: [
        v => !!v || 'E-mail is required',
      ],

      lazy: false,
    }),
    created()
    {
        if(User.loggedIn())
        {
            this.$router.push({name:'forum'});
        }
    },
    methods: {
      reset () {
        this.$refs.form.reset()
      },
      signUp() {
          this.$Progress.start();
          axios.post('/api/register',this.form)
          .then((response) => {
              User.responseAfterLogin(response)
              this.errors = {};
              this.$Progress.finish();
              this.$router.push('/forum')
          }).catch((err) => {
              this.$Progress.fail();
              this.errors = err.response.data.errors
          });
      }
    },
  }
</script>

<style>

</style>
