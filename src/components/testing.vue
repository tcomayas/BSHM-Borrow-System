<template>
  <button @click="fetchSomeAtion" style="padding: 5px; background-color: gray">Fetch</button>
  <div>
    {{ test_data }}
  </div>
</template>

<script setup>
import { defineComponent, ref } from 'vue';

defineComponent({
  name: 'TestingComponent'
})

const test_data = ref([]);

const fetchSomeAtion = async () => {
  try {
    const response = await fetch(`http://localhost/account-management-system-master/backend/admin/router.php`, {
      method: 'POST',
      body: JSON.stringify({
        choice: 'get_item',
        item_id: 1,
      })
    }).then(res => res.ok ? res.json : res)
    .then(data => data)
    .catch(error => console.error(error))

    console.log(response)
  } catch (error) {
    throw error;
  }
}

</script>
