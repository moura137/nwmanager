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
            controller: 'HomeCtrl',
            title: 'Dashboard | '
        })

        .state('painel.client', {
            url: '/client',
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListCtrl',
            title: 'Clientes | '
        })

        .state('painel.client_show', {
            url: '/client/:id/show',
            templateUrl: 'build/views/client/show.html',
            controller: 'ClientShowCtrl',
            title: 'Cliente | '
        })

        .state('painel.client_new', {
            url: '/client/new',
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewCtrl',
            title: 'Novo Cliente | '
        })

        .state('painel.client_edit', {
            url: '/client/:id/edit',
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditCtrl',
            title: 'Editar Cliente | '
        })

        .state('painel.client_delete', {
            url: '/client/:id/delete',
            templateUrl: 'build/views/client/delete.html',
            controller: 'ClientDeleteCtrl',
            title: 'Excluir Cliente | '
        })

        .state('painel.user', {
            url: '/user',
            templateUrl: 'build/views/user/list.html',
            controller: 'UserListCtrl',
            title: 'Usuários | '
        })

        .state('painel.user_new', {
            url: '/user/new',
            templateUrl: 'build/views/user/new.html',
            controller: 'UserNewCtrl',
            title: 'Novo Usuário | '
        })

        .state('painel.user_edit', {
            url: '/user/:id/edit',
            templateUrl: 'build/views/user/edit.html',
            controller: 'UserEditCtrl',
            title: 'Editar Usuário | '
        })

        .state('painel.user_delete', {
            url: '/user/:id/delete',
            templateUrl: 'build/views/user/delete.html',
            controller: 'UserDeleteCtrl',
            title: 'Excluir Usuário | '
        })

        .state('painel.project', {
            url: '/project',
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListCtrl',
            title: 'Projetos | '
        })

        .state('painel.project_show', {
            url: '/project/:id/show?tab',
            templateUrl: 'build/views/project/show.html',
            controller: 'ProjectShowCtrl',
            title: 'Projeto | '
        })

        .state('painel.project_new', {
            url: '/project/new',
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewCtrl',
            title: 'Novo Projeto | '
        })

        .state('painel.project_edit', {
            url: '/project/:id/edit',
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditCtrl',
            title: 'Editar Projeto | '
        })

        .state('painel.project_delete', {
            url: '/project/:id/delete',
            templateUrl: 'build/views/project/delete.html',
            controller: 'ProjectDeleteCtrl',
            title: 'Excluir Projeto | '
        })

        .state('painel.project_member', {
            url: '/project/:id/members',
            templateUrl: 'build/views/project-member/list.html',
            controller: 'ProjectMemberListCtrl',
            title: 'Membros do Projeto | '
        })

        .state('painel.project_note', {
            url: '/project/:id/notes',
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListCtrl',
            title: 'Notas do Projeto | '
        })

        .state('painel.project_note_new', {
            url: '/project/:id/notes/new',
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewCtrl',
            title: 'Nova Nota do Projeto | '
        })

        .state('painel.project_note_edit', {
            url: '/project/:id/notes/:idNote/edit',
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditCtrl',
            title: 'Editar Nota do Projeto | '
        })

        .state('painel.project_note_delete', {
            url: '/project/:id/notes/:idNote/delete',
            templateUrl: 'build/views/project-note/delete.html',
            controller: 'ProjectNoteDeleteCtrl',
            title: 'Excluir Nota do Projeto | '
        })

        .state('painel.project_file_images', {
            url: '/project/:id/files-images',
            templateUrl: 'build/views/project-file/images.html',
            controller: 'ProjectFileImagesCtrl',
            title: 'Imagens do Projeto | '
        })

        .state('painel.project_file', {
            url: '/project/:id/files',
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListCtrl',
            title: 'Arquivos do Projeto | '
        })

        .state('painel.project_file_new', {
            url: '/project/:id/files/new',
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewCtrl',
            title: 'Novo Arquivo do Projeto | '
        })

        .state('painel.project_file_delete', {
            url: '/project/:id/files/:idFile/delete',
            templateUrl: 'build/views/project-file/delete.html',
            controller: 'ProjectFileDeleteCtrl',
            title: 'Excluir Arquivo do Projeto | '
        })

        .state('painel.project_task', {
            url: '/project/:id/tasks',
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListCtrl',
            title: 'Tarefas do Projeto | '
        })

        .state('painel.project_task_new', {
            url: '/project/:id/tasks/new',
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewCtrl',
            title: 'Nova Tarefa do Projeto | '
        })

        .state('painel.project_task_edit', {
            url: '/project/:id/tasks/:idTask/edit',
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditCtrl',
            title: 'Editar Tarefa do Projeto | '
        })

        .state('login', {
            url: '/login',
            templateUrl: 'build/views/login.html',
            controller: 'LoginCtrl',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            title: 'Login | '
        })

        .state('forgot', {
            url: '/forgot',
            templateUrl: 'build/views/forgot.html',
            controller: 'ForgotCtrl',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            title: 'Esqueci a Senha | '
        })

        .state('reset', {
            url: '/reset?token&email',
            templateUrl: 'build/views/reset.html',
            controller: 'ResetCtrl',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            title: 'Recuperar a Senha | '
        })

        .state('logout', {
            url: '/logout',
            resolve: {
                logout: ['$location', 'OAuthToken', function($location, OAuthToken){
                    OAuthToken.removeToken();
                    $location.url('/login');
                }]
            },
            requiredLogin: false,
        })

        .state('not-found', {
            url: '/not-found',
            templateUrl: 'build/views/errors/404.html',
            controller: 'ErrorCtrl',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            title: 'Página não Encontrada | '
        })

        .state('forbidden', {
            url: '/forbidden',
            templateUrl: 'build/views/errors/403.html',
            controller: 'ErrorCtrl',
            requiredLogin: false,
            bgLayout: 'gray-bg'
        })

        .state('server-error', {
            url: '/server-error',
            templateUrl: 'build/views/errors/500.html',
            controller: 'ErrorCtrl',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            title: 'Server Error | '
        });
    }
]);