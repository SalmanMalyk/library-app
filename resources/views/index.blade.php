@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card rounded-1 shadow">
                <div class="card-body position-relative">

                    <h4 class="card-title mb-5">Latest Books</h4>

                    <div class="table-loading d-none w-100 h-100 d-flex justify-content-center align-items-center position-absolute rounded"
                        style="background-color: rgba(0, 0, 0, 0.3); top: 0; left: 0; z-index: 1; display: none;">
                        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover table-striped" width="100%">
                        <thead>
                            <tr class="table-secondary">
                                <th scope="col">No.</th>
                                <th scope="col" width="40%">Book Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Publishing House</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center" colspan="4">No Data</td>
                            </tr>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation"
                        class="pagination-div mt-3 d-flex justify-content-between align-items-center">
                        <p>Showing results</p>
                        <ul class="pagination justify-content-end">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        let pageNo = 1;

        window.setPage = (page) => {
            pageNo = page;
            fetchBooks();
        }

        const showPaginationMetaData = (data) => {
            const from = ((pageNo - 1) * data.limit) + 1;
            const to = Math.min(pageNo * data.limit, data.total);

            $('.pagination-div p').html(`Showing results ${from} to ${to} of ${data.total}`);
        }

        const generatePagination = (data) => {
            const pagination = $('.pagination');
            let paginationData = '';
            // check if page 
            if (pageNo > 1) {
                paginationData += `
                    <li class="page-item">
                        <button
                            class="page-link" 
                            onclick="setPage(${pageNo - 1})"
                        >
                            Previous
                        </button>
                    </li>
                `;
            } else {
                paginationData += `
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                `;
            }

            for (let p = 1; p <= data.pages; p++) {
                paginationData += `
                    <li class="page-item ${p === pageNo ? 'active' : null}" aria-current="page">
                        <button
                            class="page-link" 
                            onclick="setPage(${p})"
                            ${p === pageNo ? 'disabled' : null}
                        >
                            ${p}
                        </button>
                    </li>
                `;
            }


            if (pageNo < data.pages) {
                paginationData += `
                    <li class="page-item">
                        <button
                            class="page-link" 
                            onclick="setPage(${pageNo + 1})"
                        >
                            Next
                        </button>
                    </li>
                `;
            } else {
                paginationData += `
                    <li class="page-item disabled">
                        <a class="page-link">Next</a>
                    </li>
                `;
            }

            pagination.html(paginationData);

            showPaginationMetaData(data);
        }

        const generateTable = (data) => {
            const tableBody = $('.table tbody');
            let tableData = '';
            data?.books?.forEach((item, i) => {
                tableData += `
                    <tr>
                        <th scope="row">${++i}</th>
                        <td class="text-decoration-underline text-muted text-capitalize">${item.book_title}</td>
                        <td>${item.author_name}</td>
                        <td>${item.publisher_name}</td>
                    </tr>
                `;
            });
            tableBody.html(tableData);

            generatePagination(data);
        }

        const fetchBooks = async () => {
            $.ajax({
                url: '/api/books',
                method: 'GET',
                data: {
                    page: pageNo,
                    list_type: 'paginate'
                },
                beforeSend: function() {
                    toggleLoading(false);
                },
                success: function(data) {
                    if (data.books?.length > 0) {
                        generateTable(data)
                    } else {
                        Snackbar.show({
                            text: 'No more data!',
                            pos: 'bottom-center',
                            actionTextColor: '#dc3545',
                            duration: 3000,
                        });
                    }
                },
                error: function(err) {
                    Snackbar.show({
                        text: 'Something went wrong!',
                        pos: 'bottom-center',
                        actionTextColor: '#dc3545',
                        duration: 3000,
                    });
                },
                complete: function() {
                    toggleLoading();
                }
            })
        }

        const toggleLoading = () => {
            const tableLoading = document.querySelector('.table-loading');
            tableLoading.classList.toggle('d-none');
        }


        $(document).ready(function() {
            fetchBooks();
        });
    </script>
@endpush
