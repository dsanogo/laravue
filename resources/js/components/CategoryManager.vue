<template>
  <div>
    <a @click="addCategory" class="add">+ Add Category</a>
    <h4 v-if="categories.length==0">No Category found</h4>
    <form @submit.prevent="saveCategories" v-if="categories.length > 0">
      <div v-for="(category, index) in categories" :key="index">
        <input type="text" v-model="category.name" :ref="category.name" />
        <input type="number" v-model="category.display_order" />
        <a @click="removeCategory(index)" class="remove">Delete</a>
        <div>
          <img
            v-if="category.image"
            :src="`/images/${category.image}`"
            :alt="category.name"
            width="100"
          />
          <label v-else>Image</label>
          <input type="text" v-model.lazy="category.image" />
        </div>
        <hr />
      </div>
      <button type="submit">Save</button>
      <div v-if="feedback">{{ feedback }}</div>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    initialCategories: Array
  },
  data() {
    return {
      categories: _.cloneDeep(this.initialCategories),
      feedback: ""
    };
  },
  methods: {
    removeCategory: function(index) {
      if (confirm("Are you sure to remove this category?")) {
        axios
          .delete(`api/categories/${this.categories[index].id}`, {
            category: this.categories[index]
          })
          .then(res => {
            if (res.data.success) {
              this.feedback = "Category deleted";
              setInterval(() => {
                this.feedback = "";
              }, 5000);

              this.categories = res.data.categories;
            }
          })
          .catch(err => {
            this.feedback = err;
          });
      }
    },
    addCategory: function() {
      this.categories.push({
        id: 0,
        name: "",
        image: "",
        display_order: this.categories.length + 1
      });

      this.$nextTick(() => {
        window.scrollTo(0, document.body.scrollHeight);
        this.$refs[""][0].focus();
      });
    },
    saveCategories: function() {
      axios
        .post("api/categories/upsert", {
          categories: this.categories
        })
        .then(res => {
          if (res.data.success) {
            this.feedback = "Changes Saved";
            setInterval(() => {
              this.feedback = "";
            }, 5000);
            this.categories = res.data.categories;
          }
        })
        .catch(err => {
          this.feedback = "Ooops an error occured. Please try again later.";
        });
    }
  }
};
</script>

<style scoped>
img {
  vertical-align: middle;
}

hr {
  margin-bottom: 30px;
}
</style>
