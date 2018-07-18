/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');

Scope.data.currentTime = new Date().toLocaleTimeString();
setTimeout(function () {
  Scope.data.currentTime = new Date().toLocaleTimeString();
}, 500);

view.config.cleanContainer = true;
view.init({
  class: 'clock',
  children: [
    '<i class="far fa-clock"></i>',
    {
      tag: 'span',
      text: '<>data.currentTime'
    }
  ]
});