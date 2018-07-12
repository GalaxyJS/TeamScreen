const view = Scope.import('galaxy/view');

view.init({
  class: 'container-row ',
  children: {
    class: 'widget width-full',
    children: [
      {
        tag: 'h2',
        text: 'Delays'
      },
      {
        class: 'content container-row',
        children: {}
      }
    ]
  }
});