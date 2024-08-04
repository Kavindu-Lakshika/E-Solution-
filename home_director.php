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
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#employees" aria-selected="true"
                       role="tab"><b>Employees</b></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#projects" aria-selected="false" role="tab"
                       tabindex="-1"><b>Projects</b></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#teams" aria-selected="false" role="tab"
                       tabindex="-1"><b>Teams</b></a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <?php include 'includes/home_director/employees.php'; ?>
                <?php include 'includes/home_director/projects.php'; ?>
                <?php include 'includes/home_director/teams.php'; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="project_modal">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row mt-3">
                        <h3><i class="fa fa-project-diagram"></i> Project Details</h3>
                    </div>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table id="project_details" class="table table-responsive table-striped">
                                <thead>
                                <tr>
                                    <th>Task ID</th>
                                    <th>Task Name</th>
                                    <th>Status</th>
                                    <th>Team Leader</th>
                                    <th>Employee</th>
                                    <th>Hourly Rate</th>
                                    <th>Functional Points</th>
                                    <th>Task Cost</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <h4><strong>Total Project Cost: <span id="total"></span></strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/javascript.php'); ?>
<script src="/assets/js/employees.js"></script>
<script src="/assets/js/projects.js"></script>
<script src="/assets/js/teams.js"></script>
</body>
</html>