<div class="tab-pane fade" id="teams" role="tabpanel">
    <div class="row mt-5">
        <div class="col-md-12">
            <h3><i class="fa fa-people-carry"></i> Teams</h3>
        </div>
    </div>
    <hr>

    <form action="" id="team_save_form">
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="p">Project:</label>
                <select name="p" id="p" class="form-control">
                    <option>- Select a project -</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tl">Team Leader:</label>
                <select name="tl" id="tl" class="form-control">
                    <option>- Select Project Manager -</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="emps">Employees:</label>
                <select type="text" class="form-control" name="emps" id="emps"></select>
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
                <button type="submit" class="btn btn-primary form-control" id="team_save">Save Team</button>
            </div>
        </div>
    </form>

    <div class="row mt-3">
        <div class="col-md-12" id="members">

        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">
            <table id="table_teams" class="table table-striped">
                <thead>
                <tr>
                    <th>Team ID</th>
                    <th>Project</th>
                    <th>Project Manager</th>
                    <th>Team Leader</th>
                    <th>Team Members</th>
                </tr>
                </thead>
                <tbody id="table_team_data"></tbody>
            </table>
        </div>
    </div>
</div>