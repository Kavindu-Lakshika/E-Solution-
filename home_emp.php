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
            <h3><i class="fa fa-check-double"></i> My Tasks</h3>
        </div>
    </div>

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
                    <th>Change Status</th>
                </tr>
                </thead>
                <tbody id="table_task_data"></tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/javascript.php'); ?>
<script>
    function getEmpTasks() {
        ajaxRequest(
            '/get_emp_tasks',
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
                            {data: 'name'},
                            {
                                data: null,
                                render: function (data) {
                                    return '<td><span id="status_'+data.task_id+'">'+data.status+'</span></td>';
                                }
                            },
                            {
                                data: null,
                                render: function (data) {
                                    let status = data.status;
                                    let html = '';

                                    if (status === "On Going") {
                                        html = '<td><input type="checkbox" class="mark_status" id="'+data.task_id+'"></td>';
                                    } else {
                                        html = '<td><input type="checkbox" class="mark_status" id="'+data.task_id+'" checked></td>';
                                    }

                                    return html;
                                }
                            },
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

    $(document).on('click', '.mark_status', function () {
        let tId = this.id;
        let sId = '#status_' + tId;
        let status = String($(sId).html());
        let updated_status = '';

        if (status === "Completed") {
            updated_status = "On Going";
        } else {
            updated_status = "Completed";
        }

        $(sId).html(updated_status);

        let formData = "tid=" + tId + "&status=" + updated_status;

        ajaxRequest(
            '/update_task',
            'post',
            formData,
            function (response) {
                let res = JSON.parse(response);

                if (res.status === "success") {
                    successAlert(res.message);
                } else {
                    errorAlert(res.message);
                }
            },
            function (response) {
                errorAlert("Something went wrong. Please check console.");
                console.log(response);
            }
        );
    });

    $(document).ready(function () {
        getEmpTasks();
    });
</script>
</body>
</html>