
<template>
    <v-app>
        <v-main>
            <component :is="$route.meta.layout">
                <RouterView></RouterView>
            </component>
        </v-main>
    </v-app>
</template>

<script setup>
    import { RouterView } from "vue-router";
</script>
