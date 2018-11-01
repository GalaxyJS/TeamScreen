const view = Scope.import('galaxy/view');
const inputs = Scope.import('galaxy/inputs');

const utility = Scope.import('services/utility.js');
const animations = Scope.import('services/animations.js');
const appService = Scope.import('services/app.js');

Scope.data.appService = appService;

Scope.data.waiter = null;

let randomInterval;

function selectRandomWaiter(members) {
  if (members && appService.cycle.length === members.length) {
    appService.cycle = [];
  }

  if (members && members.length) {
    let randomIndex = Math.floor(Math.random() * members.length);
    let randomWaiter = members[randomIndex];
    while (appService.cycle.indexOf(randomWaiter.id) !== -1) {
      randomIndex = Math.floor(Math.random() * members.length);
      randomWaiter = members[randomIndex];
    }

    appService.cycle.push(randomWaiter.id);
    Scope.data.waiter = randomWaiter;
  }
}

view.init({
  animations: {
    enter: animations.widgetEnter,
    leave: animations.widgetLeave
  },

  randomWaiterInterval: [
    'inputs.members',
    function (members) {
      this.rendered.then(function () {
        Scope.data.waiter = null;
        if (appService.cycle.length === 0) {
          selectRandomWaiter(members);
        } else {
          const lastPersonId = appService.cycle[appService.cycle.length - 1];
          Scope.data.waiter = members.find(function (member) {
            return member.id === lastPersonId;
          })
        }

        clearInterval(randomInterval);
        randomInterval = setInterval(function () {
          selectRandomWaiter(members);
        }, (60 * 1000) * 120);
      });

      return '';
    }
  ],

  lifecycle: {
    postDestroy: function () {
      clearInterval(randomInterval);
    }
  },

  class: 'container-row',
  children: {
    class: 'widget width-full time-for-drink',
    children: [
      {
        tag: 'h2',
        text: 'Time for Drink'
      },
      {
        class: 'content',
        children: [
          {
            tag: 'p',
            class: 'person-item spotlight',
            children: [
              {
                tag: 'img',
                class: 'avatar',
                src: [
                  'data.waiter.username',
                  utility.avatarURL.big
                ]
              },
              {
                tag: 'span',
                html: [
                  'data.waiter.name',
                  function (name) {
                    return '<strong>' + name + '</strong>, it\'s your turn to bring us the drinks!';
                  }
                ]
              }
            ]
          },
          {
            animations: {
              enter: Object.assign({}, animations.itemEnter, {
                parent: true,
                sequence: 'time-for-drink'
              })
            },

            tag: 'p',
            class: [
              'member.id',
              'data.appService.cycle',
              function (memberId, ac) {
                const result = ['person-item'];

                if (ac.indexOf(memberId) !== -1) {
                  result.push('disable');
                }

                return result;
              }
            ],

            $for: {
              data: '<>inputs.members.changes',
              as: 'member'
            },
            children: [
              {
                tag: 'img',
                class: 'avatar',
                src: [
                  'member.username',
                  utility.avatarURL.medium
                ]
              },
              {
                tag: 'strong',
                text: '<>member.name'
              },
              {
                class: 'content',

                inputs: {
                  member: '<>member'
                },
                text: '<>member.drink_preference'
              }
            ]
          }
        ]
      }
    ]
  }
});