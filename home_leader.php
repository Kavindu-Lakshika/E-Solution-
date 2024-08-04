<!doctype html>
<html lang="en">
<head>
    <?php include('includes/styles.php'); ?>
    <title>E-Solutions - Home</title>
</head>
<body>
<?php include('includes/navbar.php'); ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <h3><i class="fa fa-people-carry"></i> Tasks to Employees</h3>
        </div>
    </div>

    <form action="" id="team_save_form">
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="tm">Team Member:</label>
                <select name="tm" id="tm" class="form-control">
                    <option>- Select a Team Member -</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="ts">Tasks:</label>
                <select type="text" class="form-control" name="ts" id="ts">
                    <option>- Select a Task -</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-warning form-control d-none" id="team_update">Update Team</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success form-control" id="team_clear">Clear Form</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary form-control" id="team_save">Save Tasks</button>
            </div>
        </div>
    </form>

    <div class="row mt-3">
        <div class="col-md-12" id="tasks">

        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">
            <table id="table_tasks" class="table table-striped">
                <thead>
                <tr>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Employee</th>
                </tr>
                </thead>
                <tbody id="table_task_data"></tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/javascript.php'); ?>
<script>
    let members = [];
    let tasks = [];
    let selected_tasks = [];

    function getTlData() {
        ajaxRequest(
            '/get_tl_data',
            'post',
            [],
            function (response) {
                let res = JSON.parse(response);

                members = res.result.members;
                tasks = res.result.tasks;

                let tasks_el = $('#ts');
                let teams_el = $('#tm');

                tasks_el.html('');
                teams_el.html('');

                let tasks_html = '<option>- Select a Task -</option>';
                let teams_html = '<option>- Select a Team Member -</option>';

                $.each(members, function (index, member) {
                    teams_html += '<option value="'+member.user_id+'">'+member.fname+' '+member.lname+'</option>';
                });

                $.each(tasks, function (index, task) {
                    tasks_html += '<option value="'+task.task_id+'">'+task.name+'</option>';
                });

                tasks_el.html(tasks_html);
                teams_el.html(teams_html);
            },
            function (response) {
                errorAlert("Something went wrong, please try again");
                console.log(response);
            }
        );
    }

    function setTeams() {
        $('#p').on('change', function () {
            let pid = $('#p').val();

            $('#t').html('');
            let tHtml = '<option>- Select a Team -</option>';

            $('#ts').html('');
            let tsHtml = '<option>- Select a Task -</option>';

            $.each(teams, function (index, t) {
                if (pid == t.project_id) {
                    tHtml += '<option value="'+t.team_id+'">'+t.team_id+'</option>';
                }
            });

            $.each(tasks, function (index, ts) {
                if (pid == ts.project_id) {
                    tsHtml += '<option value="'+ts.task_id+'">'+ts.name+'</option>';
                }
            });

            $('#t').html(tHtml);
            $('#ts').html(tsHtml);
        });
    }

    function addTasks() {
        $('#ts').on('change', function () {
            let tsId = $('#ts').val();
            let alreadyInTasks = false;

            if (selected_tasks.length > 0) {
                $.each(selected_tasks, function (index, ts) {
                    if (tsId === ts) {
                        alreadyInTasks = true;
                        return false;
                    }
                });

                if (alreadyInTasks) {
                    errorAlert('Employee already added to the team.');
                } else {
                    selected_tasks.push(tsId);
                }
            } else {
                selected_tasks.push(tsId);
            }

            let html = '';

            $.each(selected_tasks, function (index, ts) {
                html += '<div class="btn-group" role="group" style="margin-left: 5px;">' +
                    '<button type="button" class="btn btn-success">' + ts + '</button>' +
                    '<div class="btn-group" role="group">' +
                    '<button id="' + index + '" type="button" class="btn btn-success delete_task"><i class="fa fa-trash"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>';
            });

            let display_task = $('#tasks');
            display_task.html('');
            display_task.append(html);
        });
    }

    function setTaskMember() {
        $('#team_save_form').on('submit', function (e) {
            e.preventDefault();

            let tm = $('#tm').val();
            let ts = JSON.stringify(selected_tasks);
            let formData = "tm=" + tm + "&ts=" + ts;

            ajaxRequest(
                '/set_task_mem',
                'post',
                formData,
                function (response) {
                    let res = JSON.parse(response);

                    if (res.status === "success") {
                        successAlert(res.message);
                        clearForm();
                    }
                },
                function (response) {
                    errorAlert('Something went wrong. Check console.');
                    console.log(response);
                }
            ).then(function () {
                getPmTasks();
                let table_tasks = $('#table_tasks');
                table_tasks.DataTable().destroy();
                table_tasks.DataTable({
                    "order": []
                });
            });
        });
    }

    function clearForm() {
        getTlData();
        $('#tm').html('');
        $('#ts').html('');
        $('#tasks').html('');
        selected_tasks = [];
    }

    function gettlTasks() {
        ajaxRequest(
            '/get_tl_tasks',
            'post',
            [],
            function (response) {
                let res = JSON.parse(response);

                if (res.status === "success") {
                    let pmTasks = res.result;

                    $('#table_tasks').DataTable({
                        destroy: true,
                        data: pmTasks,
                        columns: [
                            {data: 'task_name'},
                            {data: 'status'},
                            {data: 'fname'}
                        ]
                    });

                    $('#table_tasks').removeAttr('style');
                } else {
                    errorAlert(res.message);
                }
            },
            function (response) {
                errorAlert("Something went wrong. Please check console.");
                console.log(response);
            }
        );
    }

    $(document).on('click', '.delete_task', function () {
        selected_tasks.splice(this.id, 1);

        let html = '';

        $.each(selected_tasks, function (index, ts) {
            html += '<div class="btn-group" role="group" style="margin-left: 5px;">' +
                '<button type="button" class="btn btn-success">' + ts + '</button>' +
                '<div class="btn-group" role="group">' +
                '<button id="' + index + '" type="button" class="btn btn-success delete_task"><i class="fa fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>';
        });

        let display_task = $('#tasks');
        display_task.html('');
        display_task.append(html);
    });

    $(document).ready(function () {
        getTlData();
        setTeams();
        addTasks();
        setTaskMember();
        gettlTasks();
    });
</script>
</body>
</html>