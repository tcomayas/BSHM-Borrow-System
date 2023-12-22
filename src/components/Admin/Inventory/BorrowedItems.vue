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
                Borrowerer: {{ data.fullname }}
                <v-spacer/>
                Department: {{ data.department.toUpperCase() }}
                <v-spacer/>
                Date borrowed: {{ format(new Date(data.date_borrowed), 'PPPP') }}
                <v-spacer/>
                Date returned: {{ data.status === 'active' ? 'Not yet' : format(new Date(data.date_updated), 'PPPP') }} 
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="blue" v-if="data.status !== 'inactive'" prepend-icon="mdi-tag-arrow-left-outline" @click="returnBorrowedItem(data.borrowed_id)">Returned</v-btn>
            </v-card-actions>
        </v-card>
</template>

<script setup>
import { format } from 'date-fns';

defineProps({
    data: {},
    index: null,
});

const emits = defineEmits('returnBorrowedItem');

const returnBorrowedItem = (borrowed_id) => {
    emits('returnBorrowedItem', borrowed_id);
}

const checkIfReturned = (borrow_date, return_date) => {
    const borrowDate = new Date(borrow_date);
    const returnDate = new Date(return_date);
    console.log((borrowDate.getDate() === returnDate.getDate()))
    return (borrowDate.getDate() === returnDate.getDate());
}
</script>
