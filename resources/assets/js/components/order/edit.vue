<template>
    <form @submit.prevent="onSubmit"">

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Estado actual: <span class="badge badge-secondary">{{order.status}}</span></label>

            <b-col md="6">
                <b-form-select
                        class="mb-3"
                        :class="[{ 'is-invalid' : errors.has('estado')  }]"
                        name="status"
                        :options="options"
                        v-validate="'required'"
                        data-vv-name="estado"
                        v-model="status">
                </b-form-select>

                <span v-show="errors.has('estado')" class="invalid-feedback">
                    <b v-text="errors.first('estado')"></b>
                </span>
            </b-col>
        </div>

          <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Precio</label>

              <b-col md="6">
                  <vue-numeric
                          class="form-control"
                          :class="[{ 'is-invalid' : errors.has('precio')  }]"
                          currency="RD $"
                          separator=","
                          v-bind:precision="2"
                          v-validate="'required|numeric|min_value:100|max_value:900000000'"
                          name="price"
                          :disabled="order.status !== 'EN ESPERA'"
                          data-vv-name="precio"
                          v-model="price"
                  ></vue-numeric>

                  <span v-show="errors.has('precio')" class="invalid-feedback">
                      <b v-text="errors.first('precio')"></b>
                  </span>
              </b-col>
          </div>

          <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Cantidad</label>

              <b-col md="6">
                  <vue-numeric
                          class="form-control"
                          :class="[{ 'is-invalid' : errors.has('cantidad')  }]"
                          separator=","
                          name="stock"
                          v-validate="'numeric|max_value:100'"
                          data-vv-name="cantidad"
                          v-model="quantity"
                  ></vue-numeric>

                  <span v-show="errors.has('cantidad')" class="invalid-feedback">
                      <b v-text="errors.first('cantidad')"></b>
                  </span>
              </b-col>
          </div>

          <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary" :class="loading ? 'loader' : ''">
                      Actualizar
                  </button>
              </div>
          </div>

    </form>
</template>

<script>
    import VueNumeric from 'vue-numeric';

    export default {
        name: "order-update",
        props: ['website', 'order'],
        components: { VueNumeric },
        data() {
            return {
                price:  this.order.price !== null ? this.order.price : 0,
                quantity: this.order.quantity !== null ? this.order.quantity : 0,
                status: this.order.status,
                options: [
                    { value: 'EN PROCESO', text: 'Marcar como En Proceso' },
                    { value: 'COMPLETADA', text: 'Marcar como Completado' },
                    { value: 'CANCELADA', text: 'Marcar como Cancelado' }
                ],
                loading: false,
            }
        },
        methods: {
            onSubmit() {
                this.$validator.validateAll().then((valid) => {
                    if (valid) {
                        this.loading = true;
                        axios.put(`/client/${this.website.username}/orders/${this.order.id}`, {
                            price:  this.order.status === 'EN ESPERA' ? this.price : null,
                            quantity: this.quantity,
                            status: this.status,
                        }).then(() => {
                            toastr.success("¡Actualizado correctamnet!");
                            this.loading = false;

                            setTimeout(() => {
                                window.location.href = `/client/${this.website.username}/orders`;
                            }, 3000);
                        }).catch((error) => {
                            toastr.error(error.response.data.message);
                            this.loading = false;
                        });
                    }
                });
            },
        }

    }
</script>