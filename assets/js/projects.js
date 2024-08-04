let tasks = [];
let projects = [];

function addTasks() {
    $('#add_task').click(function () {
        let task = $('#tasks').val();
        let fp = $('#fps').val();

        let taskObj = {
            task: task,
            fp: fp
        }

        tasks.push(taskObj);

        let html = '';

        $.each(tasks, function (index, task) {
            html += '<div class="btn-group" role="group" style="margin-left: 5px;">' +
                '<button type="button" class="btn btn-success">' + task.task + ' - ' + task.fp + '</button>' +
                '<div class="btn-group" role="group">' +
                '<button id="' + index + '" type="button" class="btn btn-success delete_task"><i class="fa fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>';
        });

        let taskList = $('#task_list');
        taskList.html('');
        taskList.append(html);

        $('#tasks').val('');
        $('#fps').val('');
    });
}

function getPMs() {
    ajaxRequest(
        '/get_pms',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                let pms = res.result;
                let html = '';

                $.each(pms, function (index, pm) {
                    html += '<option value="' + pm.user_id + '">' + pm.fname + ' ' + pm.lname + '</option>';
                });

                $('#pm').append(html);
            } else if (res.status === "error") {
                errorAlert(res.message);
            }
        },
        function (response) {
            console.log(response);
        }
    );
}

function saveProject() {
    $('#proj_save_form').on('submit', function (e) {
        e.preventDefault();

        let pn = $('#pn').val();
        let pm = $('#pm').val();
        let taskString = JSON.stringify(tasks);
        let formData = "pn=" + pn + "&pm=" + pm + "&tasks=" + taskString;

        ajaxRequest(
            '/save_proj',
            'post',
            formData,
            function (response) {
                let res = JSON.parse(response);

                if (res.status === "success") {
                    successAlert(res.message);
                    clearProjForm();
                } else {
                    errorAlert(res.message);
                }
            },
            function (response) {
                console.log(response);
            }
        ).then(function () {
            getAllProjects();
            let table_emp = $('#table_proj');
            table_emp.DataTable().destroy();
            table_emp.DataTable({
                "order": []
            });
        });
    });
}

function getAllProjects() {
    ajaxRequest(
        '/get_all_proj',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                projects = res.result;

                $('#table_proj').DataTable({
                    destroy: true,
                    data: projects,
                    columns: [
                        {data: 'project_id'},
                        {data: 'name'},
                        {data: 'fname'},
                        {
                            data: null,
                            render: function (data, type, row) {
                                return '<button id="' + data.project_id + '" class="btn btn-success proj_view" style="margin-right: 5px;"><i class="fa fa-eye"></i></button>';
                            }
                        }
                    ]
                });

                $('#table_proj').removeAttr('style');
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

function clearProjForm() {
    $('#proj_save_form')[0].reset();
    tasks = [];
    $('#task_list').html('');
}

$(document).on('click', '.proj_view', function () {
    let pid = this.id;
    let formData = 'pid=' + pid;

    ajaxRequest(
        '/get_project',
        'post',
        formData,
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                let details = res.result;

                $('#project_details').DataTable({
                    destroy: true,
                    data: details,
                    columns: [
                        {data: 'task_id'},
                        {data: 'task_name'},
                        {data: 'status'},
                        {data: 'team_leader'},
                        {data: 'emp_name'},
                        {data: 'hourly_rate'},
                        {data: 'functional_point'},
                        {data: 'task_cost'}
                    ]
                });

                $('#project_details').removeAttr('style');

                let total = 0;

                $.each(details, function (index, d) {
                    total += parseInt(d.task_cost);
                });

                $('#total').html(total);
                $('#project_modal').modal('show');
            } else {
                errorAlert(res.message);
            }
            console.log(res);
        },
        function (response) {
            let res = JSON.parse(response);
            console.log(res);
        }
    );
});

$(document).on('click', '.delete_task', function () {
    tasks.splice(this.id, 1);

    let html = '';

    $.each(tasks, function (index, task) {
        html += '<div class="btn-group" role="group" style="margin-left: 5px;">' +
            '<button type="button" class="btn btn-success">' + task.task + ' - ' + task.fp + '</button>' +
            '<div class="btn-group" role="group">' +
            '<button id="' + index + '" type="button" class="btn btn-success delete_task"><i class="fa fa-trash"></i>' +
            '</button>' +
            '</div>' +
            '</div>';
    });

    let taskList = $('#task_list');
    taskList.html('');
    taskList.append(html);
});

$(document).ready(function () {
    $('#proj_clear').click(function () {
        clearProjForm();
    });

    $('#example-getting-started').multiselect();

    getPMs();
    addTasks();
    saveProject();
    getAllProjects();
});