<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" @click="exportToExcel" type="button">Excel</button>
                                    <button class="dropdown-item" @click="exportToCSV" type="button">CSV</button>
                                    <button class="dropdown-item" @click="printTable" type="button">Print</button>
                                </div>
                            </div>

                            <div class="col-3">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
                            </div>
                        </div>

                        <div class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="influencerlist" class="display dataTable table-bordered" style="width:100%;">
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
                                        <tbody v-if="paginatedInfluencers.length > 0">
                                            <tr v-for="(influencer, index) in paginatedInfluencers" :key="influencer.id">
                                                <td>{{ (currentPage - 1) * influencersPerPage + index + 1 }}</td>
                                                <td>{{ influencer.card_code }}</td>
                                                <td>{{ influencer.influencer_code }}</td>
                                                <td>{{ influencer.fname }} {{ influencer.mname }} {{ influencer.lname }}</td>
                                                <td>{{ influencer.blog_name }}</td>
                                                <td>{{ influencer.blog_category }}</td>
                                                <td>{{ influencer.contact }}</td>
                                                <td>{{ influencer.email }}</td>
                                                <td>{{ formatAddress(influencer) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <button @click="showApprovalModal(influencer.user_id)" class="btn btn-success btn-sm mr-2">Approve</button>
                                                        <button @click="showArchiveModal(influencer.user_id)" class="btn btn-danger btn-sm">Archive</button>
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
                                      <!-- Pagination Controls -->
                                      <nav>
                                        <ul class="pagination justify-content-left">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <button class="page-link" @click="goToPage(currentPage - 1)">Previous</button>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                                                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                                            </li>
                                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                                <button class="page-link" @click="goToPage(currentPage + 1)">Next</button>
                                            </li>
                                        </ul>
                                    </nav>
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
import { ref, onMounted, watch, computed } from 'vue';
import { debounce } from 'lodash';
import * as XLSX from 'xlsx';
import Swal from 'sweetalert2';

const toastr = useToastr();
const influencers = ref([]);
const searchQuery = ref('');

const currentPage = ref(1);
const influencersPerPage = 10;
// Fetch influencers from API
const getInfluencers = async () => {
    try {
        const response = await axios.get('/api/influencers-pending', { params: { query: searchQuery.value } });
        influencers.value = response.data;
    } catch (error) {
        console.error('Error fetching influencers:', error);
        toastr.error('Failed to fetch influencers.');
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

// Computed property for paginated influencers
const paginatedInfluencers = computed(() => {
    const start = (currentPage.value - 1) * influencersPerPage;
    return influencers.value.slice(start, start + influencersPerPage);
});

// Computed property for total pages
const totalPages = computed(() => {
    return Math.ceil(influencers.value.length / influencersPerPage);
});

// Function to navigate to a specific page
const goToPage = (page) => {
    if (page < 1 || page > totalPages.value) return;
    currentPage.value = page;
};



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
            await updateInfluencerStatus(influencerId, 'approve');
        }
    });
};



// Show archive modal
const showArchiveModal = (influencerId) => {
    Swal.fire({
        title: 'Archive Influencer',
        text: 'Are you sure you want to archive this influencer?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Archive',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await updateInfluencerStatus(influencerId, 'archive');
        }
    });
};

// Update influencer status
const updateInfluencerStatus = async (influencerId, action) => {
    const endpoint = action === 'approve' ? `/api/influencer/${influencerId}/status/approve` : `/api/influencer/${influencerId}/status/archive`;
    const status = action === 'approve' ? 1 : 5;

    try {
        await axios.patch(endpoint, { status });
        toastr.success(`Influencer ${action === 'approve' ? 'approved' : 'archived'} successfully.`);
        getInfluencers(); // Refresh the list
    } catch (error) {
        console.error(`Error updating influencer status:`, error);
        toastr.error(`Failed to ${action} influencer.`);
    }
};

// Format address for display
const formatAddress = (influencer) => {
    return `${influencer.zip} ${influencer.street} ${influencer.city}, ${influencer.province}`;
};

// Format rows for export excluding the "Action" column
const formatRows = (rows) => {
    return rows.map((influencer, index) => [
        index + 1,
        influencer.card_code,
        influencer.influencer_code,
        `${influencer.fname} ${influencer.mname} ${influencer.lname}`,
        influencer.blog_name,
        influencer.blog_category,
        influencer.contact,
        influencer.email,
        formatAddress(influencer),
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
    tableClone.querySelectorAll('th:nth-child(10), td:nth-child(10)').forEach(cell => cell.remove()); // Remove Action column
    const newWindow = window.open('', '_blank');
    newWindow.document.write(`<html><head><title>Influencer List</title></head><body>${tableClone.outerHTML}</body></html>`);
    newWindow.document.close();
    newWindow.print();
};
</script>

