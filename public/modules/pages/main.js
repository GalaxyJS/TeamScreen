/** @type Galaxy.View */
const view = Scope.import('galaxy/view');
const router = Scope.import('galaxy/router');

const apiService = Scope.import('services/api.js');
const appService = Scope.import('services/app.js');

Scope.data.appService = appService;
Scope.data.slideShow = true;
Scope.data.slideInterval = 10 * 60;
Scope.data.teams = [];

function fetchTeams() {
  apiService.getAllTeams().then(function (teams) {
    Scope.data.teams = teams;
    appService.setAllTeams(teams);
  });
}

fetchTeams();

let slideShowInterval;
const slides = {
  'scrum-board': '/overview',
  'overview': '/scrum-board'
};

clearInterval(slideShowInterval);

setSlideShow.watch = ['data.slideShow'];

function setSlideShow(flag) {
  console.log(router);
  if (flag) {
    slideShowInterval = setInterval(function () {
      const module = router.urlParts[0];
      if (module === 'scrum-board' || module === 'overview') {
        router.navigateFromHere(slides[module]);
      }
    }, Scope.data.slideInterval * 1000);
  } else {
    clearInterval(slideShowInterval);
  }
}

activeDetector.watch = ['route', 'data.activeModule'];

function activeDetector(route, activeModule) {
  return route.module === activeModule;
}

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
  }
});

view.config.cleanContainer = true;
view.init([
  {
    app_slideShow: setSlideShow,

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
        selected: '<>data.appService.activeTeam.id',
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
              appService.activeMembers = [];
              return;
            }

            appService.setActiveTeam(this.node.value, Scope.data.teams);
          }
        }
      },
      {
        tag: 'label',
        class: 'checkbox',
        text: 'Slide Show',
        children: {
          tag: 'input',
          type: 'checkbox',
          checked: '<>data.slideShow'
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
              active: activeDetector
            },

            href: [
              'route',
              function (route) {
                return '#/' + route.id;
              }
            ],
            text: '<>route.id'
          }
        ]
      }
    ]
  },
  {
    class: 'main-content',
    module: '<>data.activeModule',
    inputs: {
      slideInterval: '<>data.slideInterval'
    },
    on: {
      'team-add': function (event) {
        fetchTeams();
      },
      'team-update': function (event) {
        fetchTeams();
      },
      'team-delete': function (event) {
        fetchTeams();
      }
    }
  }
]);