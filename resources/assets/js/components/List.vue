<template>
  <div>
    <table class="table">
      <thead>
      <tr>
        <th>Product name</th>
        <th>Quantity in stock</th>
        <th>Price per item</th>
        <th>Datetime submitted</th>
        <th>Total value number</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="product in products">
        <td>{{ product.name }}</td>
        <td>{{ product.quantity_in_stock }}</td>
        <td>${{ product.price }}</td>
        <td>{{ product.created_at }}</td>
        <td>${{ (product.quantity_in_stock * product.price).toFixed(2) }}</td>
      </tr>
      <tr v-if="sumTotalValue">
        <td colspan="4"></td>
        <td>${{ sumTotalValue.toFixed(2) }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>
<script type="text/javascript">
  export default {
    data() {
      return {
        products: []
      }
    },
    created() {
      bus.$on('products:refresh', this.fetchProducts);
      this.fetchProducts();
    },
    methods: {
      fetchProducts() {
        axios.get('/api/products')
          .then(({data}) => {
            this.products = data;
          })
      }
    },
    computed: {
      sumTotalValue() {
        return this.products
          .map(p => p.quantity_in_stock * p.price)
          .reduce((a, b) => a+b, 0);
      }
    }
  }
</script>
<style></style>