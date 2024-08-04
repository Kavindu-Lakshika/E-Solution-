<div class="tab-pane fade active show" id="employees" role="tabpanel">
    <div class="row mt-5">
        <div class="col-md-12">
            <h3><i class="fa fa-users"></i> Employees</h3>
        </div>
    </div>
    <hr>

    <form action="" id="emp_save_form">
        <input type="hidden" id="user_id" value="">
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="fn">First Name:</label>
                <input type="text" name="fn" id="fn" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="ln">Last Name:</label>
                <input type="text" name="ln" id="ln" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="un">User Name:</label>
                <input type="text" name="un" id="un" class="form-control">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4">
                <label for="pw">Password:</label>
                <input type="password" name="pw" id="pw" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="hr">Hourly Rate:</label>
                <input type="number" name="hr" id="hr" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="ut">User Type:</label>
                <select name="ut" id="ut" class="form-control">
                    <option>- Select a User Type -</option>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-warning form-control d-none" id="emp_update">Update Employee</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success form-control" id="emp_clear">Clear Form</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary form-control" id="emp_save">Save Employee</button>
            </div>
        </div>
    </form>

    <div class="row mt-3">
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-md-12">
            <table id="table_emp" class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Hourly Rate</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="table_emp_data"></tbody>
            </table>
        </div>
    </div>
</div>