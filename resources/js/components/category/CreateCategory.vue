<template>
  <v-form
        @submit.prevent="submit"
    >

        <v-text-field
            v-model="form.name"
            label="Name"
            counter="40"
            required
        ></v-text-field>
        <span class="red--text" v-if="errors.name" >
            {{ errors.name[0] }}
        </span>


      <div class="mt-3 mb-3" >
        <v-btn
            v-if="!editSlug"
            class="blue lighten-3 mr-4"
            type="submit"
        >
        Create
        </v-btn>
        <div v-else >
            <v-btn
                class="blue lighten-3 mr-4"
                type="submit"
            >
                <span>Save</span>
                <v-icon right small>fas fa-save</v-icon>
            </v-btn>
            <v-btn
                class="red"
                @click="cancelEditing"
            >Cancel
            </v-btn>
        </div>
      </div>
        <v-card>
            <v-toolbar color="indigo" dark>
                <v-toolbar-title>Categories</v-toolbar-title>
            </v-toolbar>

            <v-list>
                <transition-group name="slide" type="animation" mode="out-in" >
                    <v-list-item v-for="(category,index) in categories" :key="category.id" >
                            <div v-if="!editSlug" >
                                <v-btn icon
                                color="blue"
                                class=" mr-2"
                                dark
                                @click="startEditting(index)"
                            >
                                <v-icon>fas fa-edit</v-icon>
                            </v-btn>
                            <v-btn icon
                                color="red"
                                class="mr-3"
                                dark
                                @click="destroyCtegory(category.slug,index)"
                            >
                                <v-icon>fas fa-trash-alt</v-icon>
                            </v-btn>
                            </div>
                        <v-list-item-content>
                            <v-list-item-title v-text="category.name"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </transition-group>
            </v-list>
        </v-card>
    </v-form>
</template>

<script>
export default {
    data()
    {
        return {
            errors : {},
            categories : {},
            form : {
                name: null
            },
            editSlug : null,
            editIndex : null,
        }
    },
    methods : {
        submit()
        {
            this.editSlug ? this.editCategory() : this.storeCategory();
        },
        storeCategory()
        {
            if(User.loggedIn())
            {
                this.$Progress.start();
                axios.post('/api/categories',this.form)
                .then((response) => {
                    this.categories.unshift(response.data);
                    this.$Progress.finish();
                }).catch((err) => {
                    this.$Progress.fail();
                    this.errors = err.response.data.errors
                });
            }
        },
        editCategory()
        {

            if(User.loggedIn())
            {
                this.$Progress.start();
                axios.patch(`/api/categories/${this.editSlug}`,this.form)
                .then((response) => {
                    this.categories[this.editIndex] = response.data
                    this.editSlug = null;
                    this.form.name = null;
                    this.$Progress.finish();
                }).catch((err) => {
                    this.$Progress.fail();
                    Exception.handle(err)
                    this.errors = err.response.data.errors

                });
            }
        },
        destroyCtegory(slug,index)
        {
            if(User.loggedIn())
            {
                this.$Progress.start();
                axios.delete(`/api/categories/${slug}`)
                .then((response) => {
                    this.$Progress.finish();
                    this.categories.splice(index,1)
                }).catch((err) =>{
                    this.$Progress.fail();
                    Exception.handle(err)
                })
            }
        },
        startEditting(index)
        {
            this.form.name = this.categories[index].name;
            this.editSlug = this.categories[index].slug;
            this.editIndex = index;
            this.errors = {}

        },
        cancelEditing()
        {
            this.form.name = null;
            this.editSlug = null;
            this.editIndex = null;
            this.errors = {};
        },

    },
    created()
    {
        if(!User.admin())
        {
            this.$router.push('/forum');
        }
        axios.get('/api/categories')
        .then((response) => {
            this.categories = response.data.data
        })

    }

}
</script>

<style scoped>

.slide-enter
{
    opacity : 0;
    transform: translateX(30px);
}
.slide-enter-active
{
    transition: opacity 1s;
    animation: slide-in 2s forwards;
}
.slide-leave
{
    opacity: 1;
}
.slide-leave-active
{
    transition: opacity 1s;
    animation: slide-out .5s forwards;
    opacity: 1;

}

@keyframes slide-in {

    from
    {
        transform: translateX(50px);
    }
    to
    {
        transform: translateX(0);
    }

}
@keyframes slide-out {

    from
    {
        transform: translateX(0);
    }
    to
    {
        transform: translateX(50px);
    }

}

</style>

