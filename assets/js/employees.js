let users = [];

function getUserTypes() {
    ajaxRequest(
        '/get_user_types',
        'post',
        [],
        function (response) {
            let types = JSON.parse(response);
            let html = '';

            $.each(types, function (index, element) {
                html += '<option value="' + element.user_type_id + '">' + element.type + '</option>';
            })

            $('#ut').append(html);
        },
        function (response) {
            console.log(response);
        }
    );
}

function saveEmployee() {
    $('#emp_save_form').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        ajaxRequest(
            '/save_user',
            'post',
            formData,
            function (response) {
                let res = JSON.parse(response);

                if (res.status === 'error') {
                    errorAlert(res.message);
                } else if (res.status === 'success') {
                    successAlert(res.message);
                    $('#emp_save_form')[0].reset();
                } else {
                    console.log(response);
                }
            },
            function (response) {
                errorAlert('Something went wrong. Check console.');
                console.log(response);
            }
        ).then(function () {
            getAllUsers();
            let table_emp = $('#table_emp');
            table_emp.DataTable().destroy();
            table_emp.DataTable({
                "order": []
            });
        });
    });
}

function updateEmployee() {
    $('#emp_update').on('click', function (e) {
        let formData = $('#emp_save_form').serialize();
        formData += "&user_id=" + encodeURIComponent($('#user_id').val());

        ajaxRequest(
            '/update_user',
            'post',
            formData,
            function (response) {
                let res = JSON.parse(response);

                if (res.status === 'error') {
                    errorAlert(res.message);
                } else if (res.status === 'success') {
                    successAlert(res.message);
                    $('#emp_save_form')[0].reset();
                    $('#emp_update').addClass('d-none');
                } else {
                    console.log(response);
                }
            },
            function (response) {
                errorAlert('Something went wrong. Check console.');
                console.log(response);
            }
        ).then(function () {
            getAllUsers();
            let table_emp = $('#table_emp');
            table_emp.DataTable().destroy();
            table_emp.DataTable({
                "order": []
            });
        });
    });
}

function getAllUsers() {
    ajaxRequest(
        '/get_all_users',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                users = res.result;

                $('#table_emp').DataTable({
                    destroy: true,
                    data: users,
                    columns: [
                        {data: 'name'},
                        {data: 'un'},
                        {data: 'hourly_rate'},
                        {data: 'type'},
                        {
                            data: null,
                            render: function (data, type, row) {
                                return '<button id="' + data.user_id + '" class="btn btn-primary emp_edit" style="margin-right: 5px;"><i class="fa fa-pencil-alt"></i></button><button id="' + data.user_id + '" class="btn btn-danger emp_delete" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>';
                            }
                        }
                    ]
                });

                $('#table_emp').removeAttr('style');
            } else {
                errorAlert(res.message);
            }
        },
        function (response) {
            errorAlert('Something went wrong. Check console.');
            console.log(response);
        }
    );
}

function clearForm() {
    $('#emp_clear').on('click', function () {
        $('#emp_save_form')[0].reset();
        $('#emp_update').addClass('d-none');
    });
}

$(document).on('click', '.emp_delete', function () {
    let userId = 'id=' + this.id;

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this employee?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxRequest(
                '/delete_user',
                'post',
                userId,
                function (response) {
                    let res = JSON.parse(response);

                    if (res.status === "success") {
                        successAlert(res.message);
                    } else if (res.status === "error") {
                        errorAlert(res.message);
                    }
                },
                function (response) {
                    console.log(response);
                }
            ).then(function () {
                getAllUsers();
                let table_emp = $('#table_emp');
                table_emp.DataTable().destroy();
                table_emp.DataTable({
                    "order": []
                });
            });
        }
    });
});

$(document).on('click', '.emp_edit', function () {
    let userId = this.id;

    $('#emp_update').removeClass('d-none');

    $.each(users, function (index, user) {
        if (user.user_id === userId) {
            $('#fn').val(user.fname);
            $('#ln').val(user.lname);
            $('#un').val(user.un);
            $('#hr').val(user.hourly_rate);
            $('#ut').val(user.user_type_id);
            $('#pw').val('');
            $('#user_id').val(user.user_id);
            return '';
        }
    });
});

$(document).ready(function () {
    $('#table_emp').DataTable();
    saveEmployee();
    updateEmployee();
    getAllUsers();
    getUserTypes();
    clearForm();
});