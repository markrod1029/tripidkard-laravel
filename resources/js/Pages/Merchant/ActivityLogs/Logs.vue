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
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
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
                        <div id="activity_log_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="loglist" class="display dataTable table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time Ago</th>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>Activity</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedLogs.length > 0">
                                            <tr v-for="log in paginatedLogs" :key="log.id">
                                                <td>{{ formatDate(log.created_at) }}</td>
                                                <td>{{ formatTime(log.created_at) }}</td>
                                                <td>{{ log.causer ? `${log.causer.fname} ${log.causer.mname} ${log.causer.lname}` : 'System'
                                                    }}</td>
                                                <td>{{ log.properties.role }}</td>
                                                <td>{{ log.description }}</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5" class="text-center">No Activity Log Found</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Pagination Controls -->
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <a class="page-link"
                                                    @click.prevent="goToPage(currentPage - 1)">Previous</a>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page"
                                                :class="{ active: currentPage === page }">
                                                <a class="page-link" @click.prevent="goToPage(page)">{{ page }}</a>
                                            </li>
                                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                                <a class="page-link" @click.prevent="goToPage(currentPage + 1)">Next</a>
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
import { ref, onMounted, watch, computed } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import axios from 'axios';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import * as XLSX from 'xlsx'; // Import XLSX for Excel/CSV export

dayjs.extend(relativeTime);

const searchQuery = ref('');
const activityLogs = ref([]);
const currentPage = ref(1);
const logsPerPage = 10;

// Fetch activity logs from the API
const fetchActivityLogs = async () => {
    try {
        const response = await axios.get('/api/user/activity-logs', {
            params: { query: searchQuery.value }
        });
        activityLogs.value = response.data;
    } catch (error) {
        console.error('Error fetching activity logs:', error);
    }
};

// Watch for search query changes and fetch logs
watch(searchQuery, () => {
    currentPage.value = 1; // Reset to first page on search
    fetchActivityLogs();
}, { immediate: true });

// Get logs on component mount
onMounted(() => {
    fetchActivityLogs();
});

// Computed property for paginated logs
const paginatedLogs = computed(() => {
    const start = (currentPage.value - 1) * logsPerPage;
    return activityLogs.value.slice(start, start + logsPerPage);
});

// Computed property for total pages
const totalPages = computed(() => {
    return Math.ceil(activityLogs.value.length / logsPerPage);
});

// Function to go to a specific page
const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

// Format date and time functions
const formatDate = (timestamp) => {
    return dayjs(timestamp).format('YYYY-MM-DD');
};

const formatTime = (timestamp) => {
    return dayjs(timestamp).fromNow();
};

// Export to Excel
const exportToExcel = () => {
    try {
        if (activityLogs.value.length === 0) {
            return;
        }
        const title = ['Activity Log'];
        const headers = ['Date', 'Time Ago', 'User', 'Role', 'Activity'];
        const formattedRows = activityLogs.value.map(log => [
            formatDate(log.created_at),
            formatTime(log.created_at),
            log.causer ? `${log.causer.fname} ${log.causer.lname}` : 'System',
            log.properties.role,
            log.description
        ]);

        const worksheet = XLSX.utils.aoa_to_sheet([title, headers, ...formattedRows]);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Logs');
        XLSX.writeFile(workbook, 'ActivityLog.xlsx');
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        toastr.error('Failed to export to Excel.');
    }
};

// Export to CSV
const exportToCSV = () => {
    try {
        if (activityLogs.value.length === 0) {
            toastr.info('No data to export.');
            return;
        }
        const title = ['Activity Log'];
        const columnHeaders = ['Date', 'Time Ago', 'User', 'Role', 'Activity'];
        const formattedRows = activityLogs.value.map(log => [
            formatDate(log.created_at),
            formatTime(log.created_at),
            log.causer ? `${log.causer.fname} ${log.causer.lname}` : 'System',
            log.properties.role,
            log.description
        ]);

        const worksheet = XLSX.utils.aoa_to_sheet([title, columnHeaders, ...formattedRows]);
        const csvOutput = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvOutput], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'ActivityLog.csv');
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    } catch (error) {
        console.error('Error exporting to CSV:', error);
        toastr.error('Failed to export to CSV.');
    }
};

// Print the table
const printTable = () => {
    const printContents = document.getElementById('loglist').outerHTML;
    const newWin = window.open('');
    newWin.document.write(`
      <html>
        <head>
          <title>Print Activity Log</title>
          <style>
            table {
              width: 100%;
              border-collapse: collapse;
            }
            th, td {
              border: 1px solid #ddd;
              padding: 8px;
            }
            th {
              background-color: #f2f2f2;
            }
          </style>
        </head>
        <body onload="window.print()">
          ${printContents}
        </body>
      </html>
    `);
    newWin.document.close();
};

</script>

<style scoped>
/* Add your styles here */
</style>
