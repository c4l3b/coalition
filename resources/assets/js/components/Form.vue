<template>
  <div>
    <div class="panel">
      <form class="panel-body" @submit.prevent="save">
        <div class="form-group">
          <label class="control-label">Product name</label>
          <input class="form-control" v-model="product.name" />
        </div>
        <div class="form-group">
          <label class="control-label">Quantity in stock</label>
          <input class="form-control" v-model="product.quantity_in_stock" />
        </div>
        <div class="form-group">
          <label class="control-label">Price per item</label>
          <input class="form-control" v-model="product.price" />
        </div>
        <div class="form-group">
          <button type="submit" class="btn primary">Submit</button>
        </div>
        <div class="alert alert-danger" v-show="errorMessages.length">
          <ul>
            <li v-for="errorMessage in errorMessages" v-html="errorMessage"></li>
          </ul>
        </div>
      </form>
    </div>
  </div>
</template>
<script type="text/javascript">
  export default {
    data() {
      return {
        product: {
          name: '',
          quantity_in_stock: '',
          price: '',
        },
        errors: {}
      }
    },
    methods: {
      save() {
        axios.post('/api/products', this.product)
          .then(() => {
            bus.$emit('products:refresh');
            this.reset();
          }).catch(({response}) => {
            if (response.status === 422) {
              this.errors = response.data.errors;
            }
          });
      },
      reset() {
        this.product = {
          name: '',
          quantity_in_stock: '',
          price: '',
        };
      }
    },
    computed: {
      errorMessages() {
        let errors = [];
        Object.keys(this.errors).forEach(k => {
          this.errors[k].forEach(m => errors.push(m));
        });

        return errors;
      }
    }
  }
</script>
<style></style>