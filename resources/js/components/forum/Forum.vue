
<template>

    <v-row >
      <v-col cols="lg-8 sm-9">
          <div v-if="!show">
            <v-responsive :width="900" class="mb-5" v-for="n in 3" :key="n"  >
                <v-skeleton-loader
                    ref="skeleton"
                    :type="'list-item-three-line'"
                ></v-skeleton-loader>
            </v-responsive>
          </div>
          <transition-group name="fade" mode="out-in" v-else >
            <app-question v-for="(question,index) in questions" :key="index" :question="question" ></app-question>
          </transition-group>
            <div class="text-center">
                <v-pagination
                v-model="meta.current_page"
                :length="length"
                @input="changePage"
                ></v-pagination>
            </div>
      </v-col>
      <v-col cols="lg-4 sm-3">
        <app-sidebar></app-sidebar>
      </v-col>
    </v-row>
</template>
<script>
import Question from './Question.vue'
import Sidebar from './Sidebar.vue'
export default {

    data() {
        return {
            questions : {},
            meta : {},
            show : false
        }

    },
    components : {
        appQuestion : Question,
        appSidebar : Sidebar
    },
    created()
    {
        this.fetch();

    },
    computed : {
       length()
       {
            return this.meta.last_page;
       }
    },
    methods : {
        changePage(page)
        {
            this.$Progress.start()
            this.fetch(page);
        },
        fetch(page)
        {
            var url = page ? `/api/questions?page=${page}` : '/api/questions'
            axios.get(url)
            .then((response) => {
                this.show = true
                this.questions = response.data.data;
                this.meta = response.data.meta;
                this.$Progress.finish()
            })
            .catch((err) => {
                Exception.handle(err)
                this.$Progress.fail()
            })
        }
    }

}
</script>

<style scoped >
.fade-enter
{
    opacity: 0;
}
.fade-enter-active
{
    transition: opacity 1s ease-out;
}
.fade-leave
{
    opacity: 1;
}
.fade-leave-active
{
    transition: opacity 1s ease-out;
    opacity: 0;

}
</style>

