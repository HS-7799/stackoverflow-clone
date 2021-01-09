<template>
    <v-form
      v-model="valid"
      :lazy-validation="lazy"
       ref="form"
    >

    <v-alert type="error" v-if="errorMessage != ''" >
        {{ errorMessage }}
    </v-alert>

        <v-text-field
            v-model="form.email"
            :rules="emailRules"
            label="E-mail"
            prepend-icon="mdi-email"
            type="email"
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


      <div class="mt-3" >
        <v-btn
            :disabled="!valid"
            class="blue lighten-3 mr-4"
            @click="login"
        >
        Login
      </v-btn>

      <v-btn
        to="/register"
        color="success"
        class="mr-4"
      >
        Register
      </v-btn>
      </div>
    </v-form>
</template>

<script>
  export default {
    data: () => ({
      form : {
          email : null,
          password : null,
      },
      errors : {},
      errorMessage : '',
      showPassword : false,
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
      login()
      {
          this.$Progress.start();
        axios.post('/api/login',this.form)
        .then((response) => {
            User.responseAfterLogin(response)
            this.errors = {};
            this.$Progress.finish();
            this.$router.push('/forum')
        }).catch((err) => {
            this.$Progress.fail();
            this.errors = {}
            this.errorMessage = err.response.data.message

            if(err.response.data.success != false)
            {
                this.errors = err.response.data.errors;
            }
        });
      }
    },
  }
</script>

<style>

</style>
