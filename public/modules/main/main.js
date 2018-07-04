/** @type Galaxy.Scope*/
const view = Scope.import('galaxy/view');
const apiService = Scope.import('services/api.js');

Scope.data.currentTime = new Date().toLocaleTimeString();
setInterval(function () {
  Scope.data.currentTime = new Date().toLocaleTimeString();
}, 500);

view.config.cleanContainer = true;
view.init([
  {
    class: 'top-bar',
    module: {
      url: 'modules/components/clock.js'
    }
  },
  {
    class: 'main-content'
  }
]);

apiService.getActiveSprint(122).then(function (data) {
  debugger;
});