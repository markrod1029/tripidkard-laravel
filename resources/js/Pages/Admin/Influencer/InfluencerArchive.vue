<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div class="d-flex justify-content-between">
                            <div class=" mb-2 d-flex">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item" @click="exportToExcel"
                                            type="button">Excel</button>
                                        <button class="dropdown-item" @click="exportToCSV" type="button">CSV</button>
                                        <button class="dropdown-item" @click="printTable" type="button">Print</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <input type="text" v-model="searchQuery" class="form-control"
                                    placeholder="Search...">
                            </div>
                        </div>

                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id='influencerlist' class='display dataTable table-bordered' style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Card Code</th>
                                                <th>Influencer Code</th>
                                                <th>Influencer Name</th>
                                                <th>Blog Name</th>
                                                <th>Content Name</th>
                                                <th>Contact No.</th>
                                                <th>Email Address</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="influencers.length > 0">
                                            <tr v-for="(influencer, index) in influencers" :key="influencer.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ influencer.card_code }}</td>
                                                <td>{{ influencer.influencer_code }}</td>
                                                <td>{{ influencer.fname }} {{ influencer.mname }} {{ influencer.lname }}</td>
                                                <td>{{ influencer.blog_name }}</td>
                                                <td>{{ influencer.blog_category }}</td>
                                                <td>{{ influencer.contact }}</td>
                                                <td>{{ influencer.email }}</td>
                                                <td>{{ influencer.zip }} {{ influencer.street }} {{ influencer.city }} {{ influencer.province }}</td>
                                                <td>
                                                    <div style="display: flex; justify-content: center;">
                                                        <button @click="showApprovalModal(influencer.user_id)" class="btn btn-success btn-sm mr-2">Approve</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="10" class="text-center">No Influencers Found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx';

const toastr = useToastr();
const influencers = ref([]);
const searchQuery = ref('');
import Swal from 'sweetalert2';
// Fetch influencers from API
const getInfluencers = async () => {
    try {
        const response = await axios.get('/api/influencers-archive', { params: { query: searchQuery.value } });
        influencers.value = response.data;
    } catch (error) {
        console.error('Error fetching influencers:', error);
    }
}

// Show approval modal
const showApprovalModal = (influencerId) => {
    Swal.fire({
        title: 'Approve Influencer',
        text: `Are you sure you want to approve this influencer?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await updateInfluencerStatusApprove(influencerId, 1); // Ensure 1 is the correct status for approved
        }
    });
};
const updateInfluencerStatusApprove = async (influencerId, status) => {
    try {
        console.log('Approving influencer:', influencerId, 'with status:', status); // Log influencer ID and status
        const response = await axios.patch(`/api/influencer/${influencerId}/status/approve`, { status });
        console.log('Response from approval:', response.data); // Log response data
        toastr.success('Influencer status updated successfully.');
        getInfluencers(); // Refresh the list
    } catch (error) {
        console.error('Error updating influencer status:', error);
        toastr.error('Failed to update influencer status.');
    }
};



// Watch search query and debounce search requests
watch(searchQuery, debounce(() => {
    getInfluencers();
}, 100));

// Fetch influencers on component mount
onMounted(() => {
    getInfluencers();
});

// Format rows for export excluding the "Action" column
const formatRows = (rows) => {
    return rows.map((influencer, index) => [
        index + 1,
        influencer.card_code,
        influencer.influencer_code,  // Ensure Influencer Code is included
        `${influencer.fname} ${influencer.mname} ${influencer.lname}`,
        influencer.blog_name,
        influencer.blog_category,
        influencer.contact,
        influencer.email,
        `${influencer.zip} ${influencer.street} ${influencer.city} ${influencer.province}`,
    ]);
};

// Export to Excel
const exportToExcel = () => {
    if (influencers.value.length === 0) {
        toastr.info('No data to export.');
        return;
    }

    const headers = ['#', 'Card Code', 'Influencer Code', 'Influencer Name', 'Blog Name', 'Content Name', 'Contact No.', 'Email Address', 'Address'];
    const formattedRows = formatRows(influencers.value);

    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...formattedRows]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Influencers');
    XLSX.writeFile(workbook, 'Influencers.xlsx');
};

// Export to CSV
const exportToCSV = () => {
    if (influencers.value.length === 0) {
        toastr.info('No data to export.');
        return;
    }

    const headers = ['#', 'Card Code', 'Influencer Code', 'Influencer Name', 'Blog Name', 'Content Name', 'Contact No.', 'Email Address', 'Address'];
    const formattedRows = formatRows(influencers.value);

    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...formattedRows]);
    const csvOutput = XLSX.utils.sheet_to_csv(worksheet);

    const blob = new Blob([csvOutput], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'Influencers.csv';
    a.click();
};

// Print Table excluding the "Action" column
const printTable = () => {
    if (influencers.value.length === 0) {
        toastr.info('No data to print.');
        return;
    }

    const tableClone = document.getElementById('influencerlist').cloneNode(true);
    tableClone.querySelectorAll('th:nth-child(10), td:nth-child(10)').forEach(el => el.remove());

    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Influencer List</title>
            <style>
                body { font-family: Arial, sans-serif; }
                h2 { text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { padding: 8px; border: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
                tr:nth-child(even) { background-color: #f9f9f9; }
            </style>
        </head>
        <body>
            <h2>Influencer List</h2>
            ${tableClone.outerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
};

// Function to handle influencer archive (stub)
const archiveInfluencer = (influencerId) => {
    if (confirm('Are you sure you want to archive this influencer?')) {
        // Add logic to archive influencer
    }
};
</script>
