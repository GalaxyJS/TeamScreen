const view = Scope.import('galaxy/view');
const inputs = Scope.import('galaxy/inputs');
const apiService = Scope.import('services/api.js');
const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');

Scope.data.agendas = [];

view.init({
  animations: {
    enter: animations.widgetEnter,
    leave: animations.widgetLeave
  },

  app_agendas: [
    'inputs.team',
    function (team) {
      if (team) {
        apiService.getAgendasForTeam(team.id).then(function (agendas) {
          Scope.data.agendas = agendas;
        });

        return 'ready';
      }

      Scope.data.agendas = [];
      return 'empty';
    }
  ],

  class: 'container-row',
  children: [
    {
      class: 'widget width-full',
      children: [
        {
          tag: 'h2',
          text: 'Vacations'
        },
        {
          class: 'content',
          children: {
            tag: 'div',
            class: 'person-item',

            $for: {
              data: '<>data.agendas.changes',
              as: 'date'
            },

            children: [
              {
                children: [
                  {
                    tag: 'img',
                    class: 'avatar',
                    src: [
                      'date.member.username',
                      utility.avatarURLGenerator
                    ]
                  },

                ]
              },
              {
                class: 'content column',
                children: [
                  {
                    tag: 'h4',
                    text: '<>date.member.name'
                  },
                  {
                    tag: 'p',
                    html: [
                      'date',
                      function (date) {
                        return '<i class="far fa-calendar-alt"></i><span>' + date.start_time + ' / ' + date.end_time + '</span>';
                      }
                    ]
                  },
                ]
              },
            ]
          }
        }
      ]
    }
  ]
});
