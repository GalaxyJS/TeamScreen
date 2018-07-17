/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const router = Scope.import('galaxy/router');

const apiService = Scope.import('services/api.js');
const appService = Scope.import('services/app.js');

Scope.data.teams = [];

apiService.getAllTeams().then(function (teams) {
  Scope.data.teams = teams;
});

Scope.data.routes = [
  {
    id: 'scrum-board',
    module: {
      id: 'scrum-board',
      url: 'modules/widgets/scrum-board.js'
    }
  },
  {
    id: 'overview',
    module: {
      id: 'overview',
      url: 'modules/pages/overview.js'
    }
  },
  {
    id: 'admin',
    module: {
      id: 'admin',
      url: 'modules/admin/dashboard.js'
    }
  }
];
Scope.data.activeModule = null;

router.init({
  '/': function () {
    router.navigate('scrum-board');
  },
  '/:moduleId*': function (params) {
    const nav = Scope.data.routes.filter(function (item) {
      return item.id === params.moduleId;
    })[0];

    if (nav) {
      Scope.data.activeModule = nav.module;
    }
    console.log('hash change', params.moduleId);
  }
});

view.config.cleanContainer = true;
view.init([
  {
    class: 'top-bar',
    children: [
      {
        module: {
          url: 'modules/components/clock.js'
        }
      },
      {
        class: 'team-chooser',
        tag: 'select',
        children: [
          {
            tag: 'option',
            value: null,
            text: 'None'
          },
          {
            tag: 'option',

            $for: {
              data: '<>data.teams.changes',
              as: 'team'
            },

            value: '<>team.id',
            text: '<>team.name'
          }
        ],
        on: {
          change: function () {
            if (!this.node.value) {
              appService.activeTeam = {};
              appService.activeTeamMembers = [];
              return;
            }

            appService.setActiveTeam(this.node.value, Scope.data.teams);
          }
        }
      },
      {
        tag: 'nav',
        class: 'main-nav',
        children: [
          {
            tag: 'a',

            $for: {
              data: '<>data.routes.changes',
              as: 'route'
            },

            class: {
              active: [
                'route',
                'data.activeModule',
                function (route, activeModule) {
                  return route.module === activeModule;
                }
              ]
            },

            href: [
              'route',
              function (route) {
                return '#/' + route.id;
              }
            ],
            text: '<>route.id'
          },
        ]
      }
    ]
  },
  {
    class: 'main-content',
    module: '<>data.activeModule'
  }
]);