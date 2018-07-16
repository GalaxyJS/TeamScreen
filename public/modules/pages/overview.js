const view = Scope.import('galaxy/view');
const apiService = Scope.import('services/api.js');

Scope.data.members = null;
apiService.getAllMembers().then(function (members) {
  Scope.data.members = members;
});

view.init({
  class: 'container-row overview',
  children: [
    {
      class: 'module width-s',
      inputs: {
        members: '<>data.members'
      },
      module: {
        url: 'modules/widgets/delays.js'
      }
    },
    {
      class: 'module width-s',
      inputs: {
        members: '<>data.members'
      },
      module: {
        url: 'modules/widgets/time-for-drink.js'
      }
    }
  ]
});