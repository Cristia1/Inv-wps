<template>
  <div class="container mt-2">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2 class="text-center">Edit Invoice</h2>
          </div>
          <div class="card-body">
            <form>
              <div class="row">

                <div class="col-md-11">
                  <CustomersSelect :selected_customer_id="invoice.customer_id" ref="customers_select">
                  </CustomersSelect>

                  <div class="form-group custom-background">
                    <label for="invoice_number">Invoice Number:</label>
                    <input class="form-control" type="number" id="invoice_number" v-model="invoice.invoice_number" />
                  </div>

                  <div class="form-group custom-background">
                    <label for="due_date">Due Date:</label>
                    <input class="form-control" type="date" id="due_date" v-model="invoice.due_date" />
                  </div>

                  <div class="form-group custom-background">
                    <label for="payment_term">Payment Term:</label>
                    <select class="form-control" id="payment_term" v-model="invoice.payment_term">
                      <option value="7">7 days</option>
                      <option value="12">12 days</option>
                      <option value="14">14 days</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-11">
                  <div class="form-group custom-background">
                    <label for="currency">Currency:</label>
                    <select class="form-control" id="currency" v-model="invoice.currency">
                      <option value="usd">USD</option>
                      <option value="ron">RON</option>
                      <option value="eur">EURO</option>
                    </select>
                  </div>

                  <div class="form-group custom-background">
                    <label for="type">Type:</label>
                    <select class="form-control" id="type" v-model="invoice.type">
                      <option value="general">General</option>
                    </select>
                  </div>
                </div>
              </div>

              <InvoiceItems :invoice_items="invoice.invoice_items" ref="invoiceItems">
              </InvoiceItems>
              <br>
              <input value="Save Changes" @click.prevent="saveChanges" class="btn btn-outline-info col-md-11" alt="Button">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import CustomersSelect from "../Commons/CustomersSelect.vue";
import InvoiceItems from './InvoiceItems.vue';

    export default {
        components: {
            InvoiceItems,
            CustomersSelect,
        },
        data() {
            return {
                selectedCustomer: '',
                invoice: {
                    invoice_id: '',
                    customer_id: '',
                    invoice_number: '',
                    due_date: '',
                    payment_term: '',
                    currency: '',
                    type: 'general',
                    customers: [],
                },
            };
        },
        methods: {
            async fetchInvoice(id) {
                try {
                    const response = await axios.get(`/api/invoices/${id}/edit`);
                    this.invoice = response.data;

                } catch (error) {
                    console.error("Error fetching invoice:", error);
                }
            },
            async saveChanges() {
                try {
                    
                    const response = await axios.put(`/api/invoices/${this.invoice.id}`, {
                        customer_id: this.invoice.customer_id,
                        invoice_number: this.invoice.invoice_number,
                        due_date: this.invoice.due_date,
                        payment_term: this.invoice.payment_term,
                        currency: this.invoice.currency,
                        type: this.invoice.type,
                        items: this.$refs.invoiceItems.getItemsData(),
                    });
                    this.$router.push("/bills"); // Redirect to back route

                } catch (error) {
                    console.error("Error saving changes:", error);
                }
            }
        },
        async created() {
            const invoiceId = this.$route.params.id;
            await this.fetchInvoice(invoiceId);
        }
    };
</script>