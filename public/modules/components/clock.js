/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');

Scope.data.currentTime = new Date().toLocaleTimeString();
setInterval(function () {
  Scope.data.currentTime = new Date().toLocaleTimeString();
}, 500);

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