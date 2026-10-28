import DataTable from 'datatables.net-bs5';

function initialiseBlogsTable() {
    // Script doosre pages par table initialise nahi karega.
    const element = document.querySelector('#blogs-table');

    if (!element) return;

    const status = document.querySelector('#blog-status');
    const category = document.querySelector('#blog-category');
    const reset = document.querySelector('#blog-reset');
    const errorBox = document.querySelector('#blog-table-error');

    const table = new DataTable(element, {
        // Request ke dauran loading indicator.
        processing: true,

        // Searching, sorting aur paging backend par.
        serverSide: true,

        // Typing ke har keystroke par request avoid karo.
        searchDelay: 400,

        // Default aur allowed page sizes.
        pageLength: 10,
        lengthMenu: [10, 25, 50],

        // Small screens par table horizontally scroll hogi.
        scrollX: true,

        // Updated column descending: latest first.
        order: [[5, 'desc']],

        ajax: {
            // Blade mein generated named-route URL.
            url: element.dataset.url,

            // DataTables parameters ke saath custom filters.
            data: function (data) {
                data.status = status.value;
                data.category = category.value;

                errorBox.hidden = true;
            },

            // Failed request par visible feedback.
            error: function () {
                errorBox.hidden = false;
            },
        },

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
            },
            {
                data: 'thumbnail',
                name: 'thumbnail',
                orderable: false,
                searchable: false,
            },
            {
                data: 'title',
                name: 'title',
            },
            {
                data: 'category',
                name: 'category',
                defaultContent: '—',
            },
            {
                data: 'status_label',
                name: 'status_label',
                orderable: false,
                searchable: false,
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                searchable: false,
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
            },
        ],

        language: {
            search: 'Search:',
            searchPlaceholder: 'Title or category',
            emptyTable: 'No blogs added yet.',
            zeroRecords: 'No matching blogs found.',
        },
    });

    // Filter change par first page se fresh data.
    status.addEventListener('change', () => {
        table.ajax.reload();
    });

    category.addEventListener('change', () => {
        table.ajax.reload();
    });

    // Filters + search + sort + page size reset.
    reset.addEventListener('click', () => {
        status.value = '';
        category.value = '';

        table
            .search('')
            .order([[5, 'desc']])
            .page.len(10)
            .draw();
    });

    // Delegation: AJAX se aane wale delete forms par bhi chalega.
    element.addEventListener('submit', (event) => {
        if (!event.target.matches('[data-blog-delete]')) return;

        if (!window.confirm('Delete this blog permanently?')) {
            event.preventDefault();
        }
    });
}

// Vite module load timing dono cases mein handle karo.
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialiseBlogsTable);
} else {
    initialiseBlogsTable();
}