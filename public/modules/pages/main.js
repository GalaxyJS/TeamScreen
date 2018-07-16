/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const router = Scope.import('galaxy/router');

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
                return '#' + route.id;
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
  },
  {
    tag: 'script',
    id: 'google-api-script',
    src: 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA4Nr1bQijl7QINVIwC7JCq7Ljh2FYk_8I',
  }
]);