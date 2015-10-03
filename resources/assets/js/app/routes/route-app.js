/**
 * ------ Routes ------------
 */
angular.module('app.routes', ['ui.router'])
.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){

    $urlRouterProvider.otherwise('/not-found');

    $stateProvider
        .state('painel', {
            templateUrl: 'build/views/layout/painel.html'
        })

        .state('painel.home', {
            url: '/',
            templateUrl: 'build/views/home/dashboard.html',
            controller: 'HomeCtrl'
        })

        .state('painel.client', {
            url: '/client',
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListCtrl'
        })

        .state('painel.client_show', {
            url: '/client/:id/show',
            templateUrl: 'build/views/client/show.html',
            controller: 'ClientShowCtrl'
        })

        .state('painel.client_new', {
            url: '/client/new',
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewCtrl'
        })

        .state('painel.client_edit', {
            url: '/client/:id/edit',
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditCtrl'
        })

        .state('painel.client_delete', {
            url: '/client/:id/delete',
            templateUrl: 'build/views/client/delete.html',
            controller: 'ClientDeleteCtrl'
        })

        .state('painel.user', {
            url: '/user',
            templateUrl: 'build/views/user/list.html',
            controller: 'UserListCtrl'
        })

        .state('painel.user_new', {
            url: '/user/new',
            templateUrl: 'build/views/user/new.html',
            controller: 'UserNewCtrl'
        })

        .state('painel.user_edit', {
            url: '/user/:id/edit',
            templateUrl: 'build/views/user/edit.html',
            controller: 'UserEditCtrl'
        })

        .state('painel.user_delete', {
            url: '/user/:id/delete',
            templateUrl: 'build/views/user/delete.html',
            controller: 'UserDeleteCtrl'
        })

        .state('painel.project', {
            url: '/project',
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListCtrl'
        })

        .state('painel.project_show', {
            url: '/project/:id/show?tab',
            templateUrl: 'build/views/project/show.html',
            controller: 'ProjectShowCtrl'
        })

        .state('painel.project_new', {
            url: '/project/new',
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewCtrl'
        })

        .state('painel.project_edit', {
            url: '/project/:id/edit',
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditCtrl'
        })

        .state('painel.project_delete', {
            url: '/project/:id/delete',
            templateUrl: 'build/views/project/delete.html',
            controller: 'ProjectDeleteCtrl'
        })

        .state('painel.project_member', {
            url: '/project/:id/members',
            templateUrl: 'build/views/project-member/list.html',
            controller: 'ProjectMemberListCtrl'
        })

        .state('painel.project_note', {
            url: '/project/:id/notes',
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListCtrl'
        })

        .state('painel.project_note_new', {
            url: '/project/:id/notes/new',
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewCtrl'
        })

        .state('painel.project_note_edit', {
            url: '/project/:id/notes/:idNote/edit',
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditCtrl'
        })

        .state('painel.project_note_delete', {
            url: '/project/:id/notes/:idNote/delete',
            templateUrl: 'build/views/project-note/delete.html',
            controller: 'ProjectNoteDeleteCtrl'
        })

        .state('painel.project_file_images', {
            url: '/project/:id/files-images',
            templateUrl: 'build/views/project-file/images.html',
            controller: 'ProjectFileImagesCtrl'
        })

        .state('painel.project_file', {
            url: '/project/:id/files',
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListCtrl'
        })

        .state('painel.project_file_new', {
            url: '/project/:id/files/new',
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewCtrl'
        })

        .state('painel.project_file_delete', {
            url: '/project/:id/files/:idFile/delete',
            templateUrl: 'build/views/project-file/delete.html',
            controller: 'ProjectFileDeleteCtrl'
        })

        .state('painel.project_task', {
            url: '/project/:id/tasks',
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListCtrl'
        })

        .state('painel.project_task_new', {
            url: '/project/:id/tasks/new',
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewCtrl'
        })

        .state('painel.project_task_edit', {
            url: '/project/:id/tasks/:idTask/edit',
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditCtrl'
        })

        .state('login', {
            url: '/login',
            templateUrl: 'build/views/login.html',
            controller: 'LoginCtrl',
            access: { requiredLogin: false },
            bgLayout: 'gray-bg'
        })

        .state('forgot', {
            url: '/forgot',
            templateUrl: 'build/views/forgot.html',
            controller: 'ForgotCtrl',
            access: { requiredLogin: false },
            bgLayout: 'gray-bg'
        })

        .state('reset', {
            url: '/reset',
            templateUrl: 'build/views/reset.html',
            controller: 'ResetCtrl',
            access: { requiredLogin: false },
            bgLayout: 'gray-bg'
        })

        .state('logout', {
            url: '/logout',
            resolve: {
                logout: ['$location', 'OAuthToken', function($location, OAuthToken){
                    OAuthToken.removeToken();
                    $location.url('/login');
                }]
            },
            access: { requiredLogin: false },
        })

        .state('not-found', {
            url: '/not-found',
            templateUrl: 'build/views/errors/404.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false },
            bgLayout: 'gray-bg'
        })

        .state('forbidden', {
            url: '/forbidden',
            templateUrl: 'build/views/errors/403.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false },
            bgLayout: 'gray-bg'
        })

        .state('server-error', {
            url: '/server-error',
            templateUrl: 'build/views/errors/500.html',
            controller: 'ErrorCtrl',
            access: { requiredLogin: false },
            bgLayout: 'gray-bg'
        });
    }
]);