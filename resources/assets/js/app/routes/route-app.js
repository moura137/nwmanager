/**
 * ------ Routes ------------
 */
angular.module('app.routes', ['ngRoute'])
.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
        .when('/client', {
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListCtrl'
        })

        .when('/client/:id/show', {
            templateUrl: 'build/views/client/show.html',
            controller: 'ClientShowCtrl'
        })

        .when('/client/new', {
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewCtrl'
        })

        .when('/client/:id/edit', {
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditCtrl'
        })

        .when('/client/:id/delete', {
            templateUrl: 'build/views/client/delete.html',
            controller: 'ClientDeleteCtrl'
        })

        .when('/user', {
            templateUrl: 'build/views/user/list.html',
            controller: 'UserListCtrl'
        })

        .when('/user/new', {
            templateUrl: 'build/views/user/new.html',
            controller: 'UserNewCtrl'
        })

        .when('/user/:id/edit', {
            templateUrl: 'build/views/user/edit.html',
            controller: 'UserEditCtrl'
        })

        .when('/user/:id/delete', {
            templateUrl: 'build/views/user/delete.html',
            controller: 'UserDeleteCtrl'
        })

        .when('/project', {
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListCtrl'
        })

        .when('/project/:id/show', {
            templateUrl: 'build/views/project/show.html',
            controller: 'ProjectShowCtrl'
        })

        .when('/project/new', {
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewCtrl'
        })

        .when('/project/:id/edit', {
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditCtrl'
        })

        .when('/project/:id/delete', {
            templateUrl: 'build/views/project/delete.html',
            controller: 'ProjectDeleteCtrl'
        })

        .when('/project/:id/members', {
            templateUrl: 'build/views/project-member/list.html',
            controller: 'ProjectMemberListCtrl'
        })

        .when('/project/:id/notes', {
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListCtrl'
        })

        .when('/project/:id/notes/new', {
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewCtrl'
        })

        .when('/project/:id/notes/:idNote/edit', {
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditCtrl'
        })

        .when('/project/:id/notes/:idNote/delete', {
            templateUrl: 'build/views/project-note/delete.html',
            controller: 'ProjectNoteDeleteCtrl'
        })

        .when('/project/:id/files-images', {
            templateUrl: 'build/views/project-file/images.html',
            controller: 'ProjectFileImagesCtrl'
        })

        .when('/project/:id/files', {
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListCtrl'
        })

        .when('/project/:id/files/new', {
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewCtrl'
        })

        .when('/project/:id/files/:idFile/delete', {
            templateUrl: 'build/views/project-file/delete.html',
            controller: 'ProjectFileDeleteCtrl'
        })

        .when('/project/:id/tasks', {
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListCtrl'
        })

        .when('/project/:id/tasks/new', {
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewCtrl'
        })

        .when('/project/:id/tasks/:idTask/edit', {
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditCtrl'
        })

        .when('/', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeCtrl'
        })

        .when('/not-found', {
            templateUrl: 'build/views/404.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false }
        })

        .when('/forbidden', {
            templateUrl: 'build/views/403.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false }
        })

        .otherwise({
            redirectTo: '/not-found',
            access: { requiredLogin: false }
        });
    }
]);