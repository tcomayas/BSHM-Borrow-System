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
            <v-spacer/>
            Date added: {{ format(new Date(data.created_at), 'PPPP') }}
            <v-spacer/>
            Last update:{{ format(new Date(data.updated_at), 'PPPP') }} 
        </v-card-text>
        <v-card-text v-if="data.item_qty === 0" class="text-h3 text-center text-red">
            Out of stock
        </v-card-text>
        <v-card-actions>
              <v-spacer/>
              <v-btn color="blue" prepend-icon="mdi-square-edit-outline" @click="showEditItem(data, data.index)">Update</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import { format } from 'date-fns';

defineProps({
    data: {},
    index: null,
});

const emits = defineEmits('showEditItem');

const showEditItem = (item, index) => {
    emits('showEditItem', item, index);
}
</script>
