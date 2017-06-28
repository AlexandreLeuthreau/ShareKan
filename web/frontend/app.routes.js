'use strict';

SHARE.config(function ($stateProvider, $urlRouterProvider) {
    $stateProvider

        .state({
            name: 'kanList',
            url: '/kanList',
            component: 'kanList',
            resolve: {
                kanList: function (kanListService) {
                    return kanListService.getKanListP();
                }
            }
        })

        .state({
            name: 'kanLists',
            url: '/kanLists',
            component: 'kanLists',
        })

        .state({
            name: 'kanProfile',
            url: '/kanProfile',
            component: 'kanProfile',
        })

    $urlRouterProvider.otherwise('/kanList');

});