const view = Scope.import('galaxy/view');

view.init({
  class: 'container-row overview',
  children: [
    {
      class: 'module width-25',
      module: {
        url: 'modules/widgets/delays.js'
      }
    },
    {
      class: 'module width-25',
      module: {
        url: 'modules/widgets/time-for-drink.js'
      }
    }
  ]
});