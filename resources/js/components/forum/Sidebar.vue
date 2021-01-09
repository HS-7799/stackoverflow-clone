<template>
  <v-card
    max-width="500"
    class="mx-auto"
  >
    <v-toolbar color="indigo" dark>
      <v-toolbar-title>Categories</v-toolbar-title>
    </v-toolbar>
    <v-list>
      <v-list-item v-for="category in categories" :key="category.id" >
        {{ category.name }}
      </v-list-item>
    </v-list>
  </v-card>
</template>

<script>

export default {

    data()
    {
        return {
            categories : {}
        }
    },
    created()
    {
        axios.get('/api/categories')
        .then((response) => {
            this.categories = response.data.data
        })
        .catch((err) => {
            Exception.handle(err)
        })
    }
}

</script>
