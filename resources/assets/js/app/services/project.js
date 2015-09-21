
/**
 * Service Project
 */
angular.module('app.services')
    .service('Project', ['$resource', 'Settings', function($resource, Settings) {
        return $resource(Settings.apiUrl + '/project/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            
            update: {
                method: 'PUT'
            },

            members: {
                url: Settings.apiUrl + '/project/:id/members',
                method: 'GET',
                isArray: true
            },

            addMember: {
                url: Settings.apiUrl + '/project/:id/members/add',
                method: 'POST',
                isArray: true
            },

            removeMember: {
                url: Settings.apiUrl + '/project/:id/members/remove',
                method: 'POST',
                isArray: true
            },
        });
    }]);