<template>
        <v-card >
             <v-img
                :src="`http://localhost:4545/admin/images.php?filename=${data.item_img}`"
                width="100%"
                style=""
                height="100%"
                aspect-ratio="1/4"
                 :lazy-src="`https://picsum.photos/10/6?image=${index * (index+2) * 5 + 10}`"
                 cover
             />
             <v-card-title class="text-capitalize">
                {{ data.item_name }}
             </v-card-title>
             <v-card-text>
                Quantity: {{ data.qty }}
                <v-spacer/>
                Date borrowed: {{ format(new Date(data.date_borrowed), 'PPPP') }}
                <v-spacer/>
                Date returned: {{ data.status === 'active' ? 'Not yet' : format(new Date(data.date_updated), 'PPPP') }} 
            </v-card-text>
        </v-card>
</template>

<script setup>
import { format } from 'date-fns';

defineProps({
    data: {},
    index: null,
});

</script>
