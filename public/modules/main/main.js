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
    module: {
      url: 'modules/components/clock.js'
    }
  },
  {
    class: 'main-content',
    module: '<>data.activeModule'
  }
]);