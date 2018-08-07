const view = Scope.import('galaxy/view');
const appService = Scope.import('services/app.js');

Scope.data.mods = [
  {

    module: {
      url: 'modules/widgets/time-for-drink.js'
    }
  },
  {

    module: {
      url: 'modules/widgets/vacations.js'
    }
  },
  {
    module: {
      url: 'modules/widgets/delays.js'
    }
  }
];

Scope.data.appService = appService;
view.init({
  class: 'container-row overview',
  children: [
    {
      class: 'module width-s',

      $for: {
        data: '<>data.mods.changes',
        as: 'mod'
      },

      inputs: {
        members: '<>data.appService.activeMembers',
        team: '<>data.appService.activeTeam'
      },
      module: '<>mod.module'
    }
  ]
});