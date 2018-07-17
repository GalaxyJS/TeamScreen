const view = Scope.import('galaxy/view');
const appService = Scope.import('services/app.js');

Scope.data.appService = appService;
view.init({
  class: 'container-row overview',
  children: [
    {
      class: 'module width-s',
      inputs: {
        members: '<>data.appService.activeMembers'
      },
      module: {
        url: 'modules/widgets/time-for-drink.js'
      }
    },
    {
      class: 'module width-s',
      inputs: {
        team: '<>data.appService.activeTeam'
      },
      module: {
        url: 'modules/widgets/vacations.js'
      }
    },
    {
      class: 'module width-s',
      inputs: {
        members: '<>data.appService.activeMembers'
      },
      module: {
        url: 'modules/widgets/delays.js'
      }
    }
  ]
});