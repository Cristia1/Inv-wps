<template>
    <div>
        <a href="bills/create" class="btn btn-warning">Create Invoice</a>
        <div>
            <div class="right">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th  scope="col" class="fw-bold text-center">User ID</th>
                            <th  scope="col" class="fw-bold text-center">Customer ID</th>
                            <th  scope="col" class="fw-bold text-center" width="180px">Invoice Number</th>
                            <th  scope="col" class="fw-bold text-center">Due Date</th>
                            <th  scope="col" class="fw-bold text-center">Payment Term</th>
                            <th  scope="col" class="fw-bold text-center">Currency</th>
                            <th  scope="col" class="fw-bold text-center">Type</th>
                            <th  scope="col" class="fw-bold text-center">Actions</th>
                            <!-- <th scope="col" class="fw-bold text-center">PDF</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="invoice in invoices.data" :key="invoice.id">
                            <td>{{ invoice.user_id }}</td>
                            <td>{{ invoice.customer_id }}</td>
                            <td>{{ invoice.invoice_number }}</td>
                            <td>{{ invoice.due_date }}</td>
                            <td>{{ invoice.payment_term }}</td>
                            <td>{{ invoice.currency }}</td>
                            <td>{{ invoice.type }}</td>
                            <div class="btn-group">
                            <td class="table-gray"></td>
                            <router-link :to="`/invoices/show/${invoice.id}`"
                                class="custom-btn custom-btn-warning">Show</router-link>
                            <router-link :to="`/invoices/edit/${invoice.id}`"
                                class="custom-btn custom-btn-info">Edit</router-link>
                            <button @click="confirmDelete(invoice.id)" type="button" class="custom-btn custom-btn-success">
                                Delete
                            </button>

                            <td>
                                <a :href="generatePdfUrl(invoice.id)"  class="btn btn-success" target="_blank">Generate
                                    PDF</a>
                            </td>
                        </div>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            invoices: [],
        };
    },
    methods: {
        async fetchInvoices() {
            try {
                const response = await axios.get('/api/invoices');
                this.invoices = response.data;
            } catch (error) {
                console.error('Error fetching invoices:', error);
            }
        },
        async confirmDelete(invoiceId) {
            const shouldDelete = confirm('Are you sure you want to delete this invoice?');
            if (shouldDelete) {
                try {
                    const response = await axios.delete(`/api/invoices/${invoiceId}`);
                    console.log('Invoice deleted:', response.data);
                    this.fetchInvoices();
                } catch (error) {
                    console.error('Error deleting invoice:', error);
                }
            }
        },
        generatePdfUrl(invoiceId) {
            return `/generate-pdf/${invoiceId}`;
        },
    },
    created() {
        this.fetchInvoices();
    },
};
</script>


<style scoped>
@import '@/Assets/Components/invoices.css';
</style>