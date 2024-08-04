let projectList = [];
let tls = [];
let emps = [];
let tms = [];
let teams = [];

function getProjects() {
    ajaxRequest(
        '/get_all_proj',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                projectList = res.result;
                let html = '';

                $.each(projectList, function (index, proj) {
                    html += '<option value="' + proj.project_id + '">' + proj.name + '</option>';
                });

                $('#p').append(html);
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

function getTls() {
    ajaxRequest(
        '/get_tls',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                tls = res.result;
                let html = '';

                $.each(tls, function (index, tl) {
                    html += '<option value="' + tl.user_id + '">' + tl.fname + ' ' + tl.lname + '</option>';
                });

                $('#tl').append(html);
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

function getEmps() {
    ajaxRequest(
        '/get_employees',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                emps = res.result;
                let html = '<option>- Select an Employee -</option>';
                $('#emps').html('');

                $.each(emps, function (index, emp) {
                    html += '<option value="' + emp.user_id + '">' + emp.fname + ' ' + emp.lname + '</option>';
                });

                $('#emps').append(html);
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

function addTeamMember() {
    $('#emps').on('change', function () {
        let tmId = $('#emps').val();
        let alreadyInTeam = false;

        if (tms.length > 0) {
            $.each(tms, function (index, tm) {
                if (tmId === tm) {
                    alreadyInTeam = true;
                    return false;
                }
            });

            if (alreadyInTeam) {
                errorAlert('Employee already added to the team.');
            } else {
                tms.push(tmId);
            }
        } else {
            tms.push(tmId);
        }

        let html = '';

        $.each(tms, function (index, tm) {
            html += '<div class="btn-group" role="group" style="margin-left: 5px;">' +
                '<button type="button" class="btn btn-success">' + tm + '</button>' +
                '<div class="btn-group" role="group">' +
                '<button id="' + index + '" type="button" class="btn btn-success delete_member"><i class="fa fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>';
        });

        let members = $('#members');
        members.html('');
        members.append(html);
    });
}

function getAllTeams() {
    ajaxRequest(
        '/get_all_teams',
        'post',
        [],
        function (response) {
            let res = JSON.parse(response);

            if (res.status === "success") {
                teams = res.result;

                $('#table_teams').DataTable({
                    destroy: true,
                    data: teams,
                    columns: [
                        {data: 'team_id'},
                        {data: 'name'},
                        {data: 'project_manager_fname'},
                        {data: 'team_leader_fname'},
                        {data: 'team_members_fname'}
                    ]
                });

                $('#table_teams').removeAttr('style');
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

function saveTeam() {
    $('#team_save_form').on('submit', function (e) {
        e.preventDefault();

        let p = $('#p').val();
        let tl = $('#tl').val();
        let membersString = JSON.stringify(tms);
        let formData = "p=" + p + "&tl=" + tl + "&members=" + membersString;

        ajaxRequest(
            '/save_team',
            'post',
            formData,
            function (response) {
                let res = JSON.parse(response);

                if (res.status === "success") {
                    successAlert(res.message);
                    getEmps();
                    clearTeamForm();
                } else {
                    errorAlert(res.message);
                }
            },
            function (response) {
                console.log(response);
            }
        ).then(function () {
            getAllTeams();
            let table_teams = $('#table_teams');
            table_teams.DataTable().destroy();
            table_teams.DataTable({
                "order": []
            });
        });
    });
}

function clearTeamForm() {
    $('#team_save_form')[0].reset();
    tms = [];
    $('#members').html('');
}

$(document).on('click', '.delete_member', function () {
    tms.splice(this.id, 1);

    let html = '';

    $.each(tms, function (index, tm) {
        html += '<div class="btn-group" role="group" style="margin-left: 5px;">' +
            '<button type="button" class="btn btn-success">' + tm + '</button>' +
            '<div class="btn-group" role="group">' +
            '<button id="' + index + '" type="button" class="btn btn-success delete_member"><i class="fa fa-trash"></i>' +
            '</button>' +
            '</div>' +
            '</div>';
    });

    let members = $('#members');
    members.html('');
    members.append(html);
});

$(document).ready(function () {
    getProjects();
    getTls();
    getEmps();
    addTeamMember();
    saveTeam();
    getAllTeams();
});