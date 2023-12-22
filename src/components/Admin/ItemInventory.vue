<template>
  <v-card>
      <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
          <v-tab :value="0">Inventory Items</v-tab>
          <v-tab :value="1">Borrowed Items</v-tab>
          <v-tab :value="2">Add new Item</v-tab>
      </v-tabs>

      <v-window v-model="tab">
             <v-window-item >
                  <v-container fluid>
                       <div v-if="!isLoading && items.length === 0" style="display: flex; justify-content: center; font-size: 38px; color: gray;">
                           no items available in the inventory
                       </div>
                       <v-row v-else>
                           <v-col v-for="(item, index) in items" :key="index" cols="12" md="4">
                               <DisplayItems :data="item" :index="index" @showEditItem="showEditItem" />
                           </v-col>
                       </v-row>
                   </v-container>
               </v-window-item>

          <v-window-item >
              <v-container fluid>
                <div v-if="borrowedItems.length === 0" style="display: flex; justify-content: center; font-size: 38px; color: gray; padding: 15px 0px">
                  no borrowed items available
                </div>
                  <v-row v-else>
                      <v-col v-for="(item, index) in borrowedItems" :key="index" cols="12" md="4">
                          <BorrowedItems :data="item" :index="index" @returnBorrowedItem="returnBorrowedItem"/>
                      </v-col>
                  </v-row>
              </v-container>
          </v-window-item>

          <v-window-item >
              <v-container fluid>
                <div v-if="!isLoading && borrowedItems.length === 0" style="display: flex; justify-content: center; font-size: 38px; color: gray; padding: 15px 0px">
                  no borrowed items available
                </div>
                  <v-row v-else>
                      <AddNewItem />
                  </v-row>
              </v-container>
          </v-window-item>
      </v-window>
</v-card>

<v-dialog v-model="editItemDialog" width="80%">
      <v-card title="Edit Item Quantity">
          <v-card-text>
              <v-text-field label="Item" readonly v-model="updateItemForm.item_name"></v-text-field>
              <v-text-field label="Quantity" type="number" min="0" v-model="updateItemForm.item_qty"></v-text-field>
          </v-card-text>
          <v-card-actions>
              <v-spacer/>
              <v-btn color="grey" @click="editItemDialog = false">Cancel</v-btn>
              <v-btn color="green" @click="updateItemQuantity" :loading="isLoading">Update</v-btn>
          </v-card-actions>
      </v-card>
  </v-dialog>

</template>

<script setup>
import {ref, onMounted, watch, defineAsyncComponent } from 'vue';
import { format } from 'date-fns';
import $ from 'jquery';
import { useToastr } from '../../plugins/toastr';
import { useAnnouncementStore } from '../../stores/announcement.js';

const announceStore = useAnnouncementStore();
const DisplayItems = defineAsyncComponent({
  loader: () => import('./Inventory/DisplayItems.vue'),
  delay: 300,
  timeout: 2300,
  suspensile: false,
});

const BorrowedItems = defineAsyncComponent({
  loader: () => import('./Inventory/BorrowedItems.vue'),
  delay: 300,
  timeout: 2300,
  suspensile: false,
});

const AddNewItem = defineAsyncComponent({
  loader: () => import('./Inventory/AddNewItem.vue'),
  delay: 300,
  timeout: 2300,
  suspensile: false,
});

const toastr = useToastr();
const tab = ref(0);
const announcements = ref(null);
const editItemDialog = ref(false);
const deleteItemDialog = ref(false);
const api = 'http://localhost:4545/admin/router.php';
const isLoading = ref(false);
const items = ref([]);
const borrowedItems = ref([]);
const updateItemForm = ref({
item_name: '',
item_qty: null,
item_id: null,
});

const getInventoryItems = async () => {
try {
  isLoading.value = true;

  $.ajax({
    type: 'POST',
    url: api,
    data: {
      choice: 'get',
      item_id: 0
    },
   success: response => {
      const res = JSON.parse(response);
          if (res.status !== '403' || res.status === '501') {
              items.value = res;
          }

    },
    error: error => {
      toastr["error"](error.responseText)
      throw error;
    }
  });
} catch (error) {
  errMsg.value = error.responseText;
  throw error;
} finally {
  isLoading.value = false
}
}

const getBorrowedItems = () => {
  try {
      isLoading.value = true;
      $.ajax({
          type: 'POST',
          url: api,
          data: {
              choice: 'my_item',
              user_id: 0,
          },
          success: response => {
            console.log(response);
              const res = JSON.parse(response)
              if (res.status !== '403' || res.status === '501') {
                  borrowedItems.value = res;
              }
          },
          error: error => {
              toastr["error"](error.responseText)
              throw error;
          }
      })
  } catch (error) {
      errMsg.value = error.responseText;
      throw error;
  } finally {
      isLoading.value = false
  }
}

const showEditItem = (item, index) => {
try {
  editItemDialog.value = true;
  updateItemForm.value.item_name = item.item_name.toUpperCase();
  updateItemForm.value.item_id = item.item_id;

} catch (error) {
  throw error;
} finally {
  isLoading.value = false;
}
}

const updateItemQuantity = () => {
try {
  isLoading.value = true;

  $.ajax({
    type: 'POST',
    url: api,
    data: {
      choice: 'update',
      item_id: updateItemForm.value.item_id,
      item_qty: updateItemForm.value.item_qty
    },
    success: response => {
      const tmp = JSON.parse(response);

      const temps = items.value.find(item => item.item_id === updateItemForm.value.item_id);
      temps.item_qty = parseInt(temps.item_qty) + parseInt(updateItemForm.value.item_qty);
      temps.updated_at = Date.now();

      toastr["success"](tmp.message.toUpperCase());
      editItemDialog.value = false;
      updateItemForm.value.item_qty = null;
    },
    error: error => {
      toastr["error"](error.responseText);
      throw error;
    }
  })
} catch (error) {
  toastr["error"](error.responseText);
  throw error;
} finally {
  isLoading.value = false;
  editItemDialog.value = false;
}
}

const returnBorrowedItem = (borrowed_id) => {
  try {
      isLoading.value = true;
      $.ajax({
          type: 'POST',
          url: api,
          data: {
              choice: 'return',
              borrow_id: borrowed_id
          },
          success: async response => {
              const res = JSON.parse(response);
              toastr["success"](res.message.toUpperCase());
              const temps = borrowedItems.value.find(item => item.borrowed_id === borrowed_id);
              temps.date_updated = Date.now();
              await getBorrowedItems();
          }
      })
  } catch (error) {
      toastr["error"](error.responseText);
      throw error;
  } finally {
      isLoading.value = false;
      editItemDialog.value = false;
  }
}

onMounted(async () => {
await getInventoryItems();
await getBorrowedItems();
})

watch(() => announceStore.childState, async () => {
await getInventoryItems();
})
</script>