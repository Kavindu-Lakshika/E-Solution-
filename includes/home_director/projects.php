<div class="tab-pane fade" id="projects" role="tabpanel">
    <div class="row mt-5">
        <div class="col-md-12">
            <h3><i class="fa fa-book-reader"></i> Projects</h3>
        </div>
    </div>
    <hr>

    <form action="" id="proj_save_form">
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="pn">Project Name:</label>
                <input type="text" name="pn" id="pn" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="pm">Project Manager:</label>
                <select name="pm" id="pm" class="form-control">
                    <option>- Select Project Manager -</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tasks">Tasks:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-describedby="add_task" name="tasks" id="tasks"
                           placeholder="Task">
                    <input type="number" class="form-control" aria-describedby="add_task" name="fps" id="fps"
                           placeholder="Functional Points">
                    <button class="btn btn-primary" type="button" id="add_task"><i class="fa fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-warning form-control d-none" id="proj_update">Update Project
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success form-control" id="proj_clear">Clear Form</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary form-control" id="proj_save">Save Project</button>
            </div>
        </div>
    </form>

    <div class="row mt-2 mb-3">
        <div class="col-md-12" id="task_list"></div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">
            <table id="table_proj" class="table table-striped">
                <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Project Manager</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="table_proj_data"></tbody>
            </table>
        </div>
    </div>
</div>