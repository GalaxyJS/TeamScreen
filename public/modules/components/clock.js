/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');

Scope.data.currentTime = new Date().toLocaleTimeString();
setInterval(function () {
  Scope.data.currentTime = new Date().toLocaleTimeString();
}, 500);

view.config.cleanContainer = true;
view.init([
  {
    class: 'clock',
    text: '<>data.currentTime'
  }
]);