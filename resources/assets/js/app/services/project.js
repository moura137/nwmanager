
/**
 * Service Project
 */
angular.module('app.services')
    .service('Project', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.baseUrl + '/project/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            
            update: {
                method: 'PUT'
            },

            members: {
                url: Settings.baseUrl + '/project/:id/members',
                method: 'GET',
                isArray: true
            },

            addMember: {
                url: Settings.baseUrl + '/project/:id/members/add',
                method: 'POST',
                isArray: true
            },

            removeMember: {
                url: Settings.baseUrl + '/project/:id/members/remove',
                method: 'POST',
                isArray: true
            },
        });
    }]);