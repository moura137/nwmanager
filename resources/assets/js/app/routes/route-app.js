/**
 * ------ Routes ------------
 */
angular.module('app.routes', ['ui.router'])
.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){

    $urlRouterProvider.otherwise('/not-found');

    $stateProvider
        .state('painel', {
            abstract: true,
            title: 'Home',
            views: {
                'main@': {
                    templateUrl: 'build/views/layout/painel.html'
                }
            },
        })

        .state('painel.home', {
            url: '/',
            title: 'Project Manager',
            templateUrl: 'build/views/home/dashboard.html',
            controller: 'HomeCtrl',
        })

        .state('painel.client', {
            url: '/client',
            title: 'Clientes',
            views: {
                '@painel': {
                    templateUrl: 'build/views/client/list.html',
                    controller: 'ClientListCtrl',
                },
            },
        })

        .state('painel.client.dashboard', {
            url: '/dashboard',
            title: 'Dashboard Clientes',
            views: {
                '@painel': {
                    templateUrl: 'build/views/client/dashboard.html',
                    controller: 'ClientDashboardCtrl',
                },
            },
        })

        .state('painel.client.show', {
            url: '/:id/show',
            title: 'Detalhes Cliente',
            views: {
                '@painel': {
                    templateUrl: 'build/views/client/show.html',
                    controller: 'ClientShowCtrl',
                },
            },
        })

        .state('painel.client.new', {
            url: '/new',
            title: 'Novo Cliente',
            views: {
                '@painel': {
                    templateUrl: 'build/views/client/new.html',
                    controller: 'ClientNewCtrl',
                },
            },
        })

        .state('painel.client.edit', {
            url: '/:id/edit',
            title: 'Editar Cliente',
            views: {
                '@painel': {
                    templateUrl: 'build/views/client/edit.html',
                    controller: 'ClientEditCtrl',
                },
            },
        })

        .state('painel.client.delete', {
            url: '/client/:id/delete',
            title: 'Excluir Cliente',
            views: {
                '@painel': {
                    templateUrl: 'build/views/client/delete.html',
                    controller: 'ClientDeleteCtrl',
                },
            },
        })

        .state('painel.user', {
            url: '/user',
            title: 'Usuários',
            views: {
                '@painel': {
                    templateUrl: 'build/views/user/list.html',
                    controller: 'UserListCtrl',
                },
            },
        })

        .state('painel.user.show', {
            url: '/:id/show',
            title: 'Detalhes Usuário',
            views: {
                '@painel': {
                    templateUrl: 'build/views/user/show.html',
                    controller: 'UserShowCtrl',
                },
            },
        })

        .state('painel.user.new', {
            url: '/new',
            title: 'Novo Usuário',
            views: {
                '@painel': {
                    templateUrl: 'build/views/user/new.html',
                    controller: 'UserNewCtrl',
                },
            },
        })

        .state('painel.user.edit', {
            url: '/:id/edit',
            title: 'Editar Usuário',
            views: {
                '@painel': {
                    templateUrl: 'build/views/user/edit.html',
                    controller: 'UserEditCtrl',
                },
            },
        })

        .state('painel.user.delete', {
            url: '/:id/delete',
            title: 'Excluir Usuário',
            views: {
                '@painel': {
                    templateUrl: 'build/views/user/delete.html',
                    controller: 'UserDeleteCtrl',
                },
            },
        })

        .state('painel.project', {
            url: '/project',
            title: 'Projetos',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project/list.html',
                    controller: 'ProjectListCtrl',
                },
            },
        })

        .state('painel.project.dashboard', {
            url: '/dashboard',
            title: 'Dashboard Projetos',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project/dashboard.html',
                    controller: 'ProjectDashboardCtrl',
                },
            },
        })

        .state('painel.project.show', {
            url: '/:id/show?tab',
            title: 'Detalhes Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project/show.html',
                    controller: 'ProjectShowCtrl',
                },
            },
        })

        .state('painel.project.new', {
            url: '/new',
            title: 'Novo Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project/new.html',
                    controller: 'ProjectNewCtrl',
                },
            },
        })

        .state('painel.project.edit', {
            url: '/:id/edit',
            title: 'Editar Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project/edit.html',
                    controller: 'ProjectEditCtrl',
                },
            },
        })

        .state('painel.project.delete', {
            url: '/:id/delete',
            title: 'Excluir Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project/delete.html',
                    controller: 'ProjectDeleteCtrl',
                },
            },
        })

        .state('painel.project.member', {
            url: '/:id/members',
            title: 'Membros do Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-member/list.html',
                    controller: 'ProjectMemberListCtrl',
                },
            },
        })

        .state('painel.project.note', {
            url: '/:id/notes',
            title: 'Notas do Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-note/list.html',
                    controller: 'ProjectNoteListCtrl',
                },
            },
        })

        .state('painel.project.note.new', {
            url: '/new',
            title: 'Nova Nota',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-note/new.html',
                    controller: 'ProjectNoteNewCtrl',
                },
            },
        })

        .state('painel.project.note.edit', {
            url: '/:idNote/edit',
            title: 'Editar Nota',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-note/edit.html',
                    controller: 'ProjectNoteEditCtrl',
                },
            },
        })

        .state('painel.project.note.delete', {
            url: '/:idNote/delete',
            title: 'Excluir Nota',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-note/delete.html',
                    controller: 'ProjectNoteDeleteCtrl',
                },
            },
        })

        .state('painel.project.file', {
            url: '/:id/files',
            title: 'Arquivos do Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-file/list.html',
                    controller: 'ProjectFileListCtrl',
                },
            },
        })

        .state('painel.project.file.images', {
            url: '/images',
            title: 'Imagens do Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-file/images.html',
                    controller: 'ProjectFileImagesCtrl',
                },
            },
        })

        .state('painel.project.file.new', {
            url: '/new',
            title: 'Novo Arquivo',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-file/new.html',
                    controller: 'ProjectFileNewCtrl',
                },
            },
        })

        .state('painel.project.file.delete', {
            url: '/:idFile/delete',
            title: 'Excluir Arquivo',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-file/delete.html',
                    controller: 'ProjectFileDeleteCtrl',
                },
            },
        })

        .state('painel.project.task', {
            url: '/:id/tasks',
            title: 'Tarefas do Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-task/list.html',
                    controller: 'ProjectTaskListCtrl',
                },
            },
        })

        .state('painel.project.task.new', {
            url: '/new',
            title: 'Nova Tarefa do Projeto',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-task/new.html',
                    controller: 'ProjectTaskNewCtrl',
                },
            },
        })

        .state('painel.project.task.edit', {
            url: '/:idTask/edit',
            title: 'Editar Tarefa',
            views: {
                '@painel': {
                    templateUrl: 'build/views/project-task/edit.html',
                    controller: 'ProjectTaskEditCtrl',
                },
            },
        })

        .state('login', {
            url: '/login',
            title: 'Login',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            views: {
                'main@': {
                    templateUrl: 'build/views/login.html',
                    controller: 'LoginCtrl',
                }
            },
        })

        .state('forgot', {
            url: '/forgot',
            title: 'Esqueci a Senha',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            views: {
                'main@': {
                    templateUrl: 'build/views/forgot.html',
                    controller: 'ForgotCtrl',
                }
            },
        })

        .state('reset', {
            url: '/reset?token&email',
            title: 'Recuperar a Senha',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            views: {
                'main@': {
                    templateUrl: 'build/views/reset.html',
                    controller: 'ResetCtrl',
                }
            },
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
            title: 'Página não Encontrada',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            views: {
                'main@': {
                    templateUrl: 'build/views/errors/404.html',
                    controller: 'ErrorCtrl',
                }
            },
        })

        .state('forbidden', {
            url: '/forbidden',
            title: 'Sem Autorização',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            views: {
                'main@': {
                    templateUrl: 'build/views/errors/403.html',
                    controller: 'ErrorCtrl',
                }
            },
        })

        .state('server-error', {
            url: '/server-error',
            title: 'Server Error',
            requiredLogin: false,
            bgLayout: 'gray-bg',
            views: {
                'main@': {
                    templateUrl: 'build/views/errors/500.html',
                    controller: 'ErrorCtrl',
                }
            },
        });
    }
]);