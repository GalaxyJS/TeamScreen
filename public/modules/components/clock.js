/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');

Scope.data.ttt = 'asdsad';
Scope.data.currentTime = new Date().toLocaleTimeString();
setTimeout(function () {
  Scope.data.ttt = 'asdsad2';
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
    },
    {
      tag: 'span',
      text: '<>data.ttt'
    }
  ]
});