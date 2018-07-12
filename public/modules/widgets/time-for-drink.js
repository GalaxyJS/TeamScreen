const view = Scope.import('galaxy/view');

view.init({
  class: 'container-row',
  children: {
    class: 'widget width-full',
    children: [
      {
        tag: 'h2',
        text: 'Time for Drink'
      },
      {
        class: 'content container-row',
        children: {}
      }
    ]
  }
});