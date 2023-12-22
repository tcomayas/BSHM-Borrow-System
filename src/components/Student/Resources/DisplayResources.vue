<template>
    <v-card >
        <v-img
            :src="`http://localhost:4545/admin/images.php?filename=${data.item_img}`"
            :lazy-src="`https://picsum.photos/10/6?image=${index * (index+2) * 5 + 10}`"
            cover
        />
        <v-card-title class="text-capitalize">
            {{ data.item_name }}
        </v-card-title>
        <v-card-text>
            Quantity: {{ data.item_qty }}
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="blue" prepend-icon="mdi-package-variant-plus" @click="showEditAccouncementDialog(data.item_id, data.item_name, data.item_qty)">Borrow</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>

const emits = defineEmits(['showEditAccouncementDialog'])
const props = defineProps({
    data: {},
    index: null
});

const showEditAccouncementDialog = (item_id, item_name, item_qty) => {
    emits('showEditAccouncementDialog', item_id, item_name, item_qty);
}
</script>
