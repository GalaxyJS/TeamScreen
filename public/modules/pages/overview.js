const view = Scope.import('galaxy/view');
const appService = Scope.import('services/app.js');

Scope.data.appService = appService;

Scope.data.mods = [
  {
    module: {
      url: 'modules/widgets/time-for-drink.js'
    }
  },
  {

    module: {
      url: 'modules/widgets/vacations.js'
    }
  },
  {
    module: {
      url: 'modules/widgets/delays.js'
    }
  }
];


view.init({
  class: 'container-row overview',
  children: [
    {
      tag: 'p',
      class: 'sprint-goal',
      children: [
        {
          tag: 'strong',
          text: '<>data.activeSprint.name'
        },
        {
          tag: 'span',
          text: '<>data.activeSprint.goal'
        },
        {
          class: 'count-down',
          text: '<>inputs.timerCountDown',
          children:
            {
              tag: 'div',
              style: {
                width: [
                  'data.timerCountDown',
                  function (counter) {
                    const parentWidth = this.parent.node.offsetWidth;
                    const full = Scope.inputs.slideInterval;
                    return ((counter * parentWidth) / full) + 'px';
                  }
                ],
              }
            }

        }
      ]
    },
    {
      class: 'module width-s',

      $for: {
        data: '<>data.mods.changes',
        as: 'mod'
      },

      inputs: {
        members: '<>data.appService.activeMembers',
        team: '<>data.appService.activeTeam'
      },

      module: '<>mod.module'
    }
  ]
});