<template>
    <div>
        <v-card class="mb-3" >
            <v-card-title>
                <v-btn text :to="question.path" >
                    {{ question.title }}
                </v-btn>
            </v-card-title>
            <v-card-subtitle >
                {{ question.user }} said {{ question.created_at }}
            </v-card-subtitle>
            <v-card-text class="black--text" >
                {{ question.body }}
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {

    props : {
        question : {
            type : Object,
        }
    },


}
</script>

<style>

</style>
